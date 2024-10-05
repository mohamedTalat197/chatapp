<?php

namespace App\Validations;

use App\Core\AppResult;
use Validator,Auth;

class MessageValidation
{
    public function validate($payload)
    {
        $input = $payload->all();
        $validationMessages = [
        ];
        $validator = Validator::make($input , [
            'recipient_id' => 'exists:users,id',
            'content' => 'required|string',
        ],$validationMessages);
        if($validator->fails()){
            return AppResult::error($validator->messages()->first());
        }
        return AppResult::success(null);
    }
}
