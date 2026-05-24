<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountUserResource extends JsonResource
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
            'account_id' => $this->account_id,
            'code_id' => $this->code_id,
            'qrcode_id' => $this->qrcode_id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'account_no' => $this->account_no,
            'agent_code' => $this->agent_code,
            'about' => $this->about,
            'type' => $this->type,
            'balance' => $this->balance,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
