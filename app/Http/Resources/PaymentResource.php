<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'account_from_id' => $this->account_from_id,
            'account_to_id' => $this->account_to_id,
            'code_id' => $this->code_id,
            'qrcode_id' => $this->qrcode_id,
            'uuid' => $this->uuid,
            'amount' => $this->amount,
            'about' => $this->about,
            'type' => $this->type,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
