<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'name' => $this->name,
            'about' => $this->about,
            'phone' => $this->phone,
            'image' => $this->image,
            'url' => $this->url,
            'api' => $this->api,
            'pass' => $this->pass,
            'code_id' => $this->code_id,
            'qrcode_id' => $this->qrcode_id,
            'req_type' => $this->req_type,
            'type' => $this->type,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
