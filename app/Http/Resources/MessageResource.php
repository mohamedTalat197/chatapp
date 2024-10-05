<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'content' => $this->content,
            'sender' => new UserResource($this->sender),
            'recipient' => new UserResource($this->recipient),
        ];
    }
}
