<?php

namespace App\Repos;

use App\Core\AppResult;
use App\Helpers\ImageHelper;
use App\Helpers\NumberHelper;
use App\Models\User;
use Validator, Auth, Artisan, Hash, File, Crypt;

class UserRepo
{

    /**
     * @param $filter
     * @return mixed
     */
    public function get($filter)
    {
        $users = User::orderBy('id', 'desc');
        $limit=$filter->limit ? $filter->limit : 10;
        $users=$users->paginate($limit);
        return $users;
    }

    /**
     * @param $payload
     * @param $type
     * @return User
     */
    public function create($payload)
    {
        $user = new User();
        $user->username = $payload->username;
        $user->email = $payload->email;
        $user->password = Hash::make($payload->password);
        $user->save();
        return $user;
    }


    /**
     * @param $id
     * @return AppResult
     */
    public function getUserById($id)
    {
        $user = User::find($id);
        return AppResult::success($user);
    }


    /**
     * @param $email
     * @return AppResult
     */
    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (is_null($user))
            return AppResult::error(__('responseMessage.user_not_found'));
        return AppResult::success($user);

    }

    /**
     * @param $user
     * @param $isOnline
     * @return void
     */
    public function updateISOnline($user, $isOnline)
    {
        $user->is_online = $isOnline;
        $user->last_seen = $isOnline ? null : now();
        $user->save();
    }

    /**
     * @param $user
     */
    public function generatePaymentRef($user){
        $trackId = (string)rand(1, 1000000);
        $user->ref_payment = $trackId;
        $user->save();
    }

    /**
     * @param $ref_payment
     * @return AppResult
     */
    public function getUserByRefPayment($ref_payment){
        $user = User::where('ref_payment', $ref_payment)->first();
        if (is_null($user))
            return AppResult::error(__('responseMessage.user_not_found'));
        return AppResult::success($user);
    }





}
