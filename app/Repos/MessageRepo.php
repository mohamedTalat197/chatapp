<?php

namespace App\Repos;

use App\Core\AppResult;
use App\Helpers\ImageHelper;
use App\Helpers\NumberHelper;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator, Auth, Artisan, Hash, File, Crypt;

class MessageRepo
{

    /**
     * @param $filter
     * @return mixed
     */
    public function get($filter)
    {
        $messages = Message::orderBy('id', 'desc')
            ->where('recipient_id', $filter->user_id)
            ->orWhere('sender_id', $filter->user_id);
        $limit=$filter->limit ? $filter->limit : 10;
        $messages=$messages->paginate($limit);
        return $messages;
    }

    /**
     * @param $payload
     * @return Message
     */
    public function create($payload)
    {
        $message = new Message();
        $message->sender_id = Auth::user()->id;
        $message->recipient_id = $payload->recipient_id;
        $message->content = $payload->content;
        $message->save();
        return $message;
    }

    /**
     * @param $id
     * @return AppResult
     */
    public function getMessageById($id)
    {
        $message = Message::find($id);
        return AppResult::success($message);
    }

    /**
     * @param $request
     * @return void
     */
    public function updateIsSeen($messages_id)
    {
        DB::table('messages')->whereIn('id', $messages_id)->update(['is_seen' => 1]);
    }
}
