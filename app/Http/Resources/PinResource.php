<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PinResource extends JsonResource
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
            'user_id' => $this->user_id,
            'uuid' => $this->uuid,
            'msg' => $this->msg,
            'code' => $this->code,
            'codeable_type' => $this->codeable_type,
            'codeable_id' => $this->codeable_id,
            'expired_at' => $this->expired_at,
            'type' => $this->type,
            'status' => $this->status,
            'right' => $this->right,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
