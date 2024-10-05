<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'is_online' => (int)$this->is_online,
            'last_seen' =>DateHelper::getInstance()->customDateFormatWithTime($this->last_seen),
            'created_at'=>DateHelper::getInstance()->customDateFormat($this->created_at),
            'token' => $this->user_token,
        ];
    }
}
