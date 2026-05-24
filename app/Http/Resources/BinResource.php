<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BinResource extends JsonResource
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
            'binable_type' => $this->binable_type,
            'binable_id' => $this->binable_id,
            'duration_value' => $this->duration_value,
            'duration' => $this->duration,
            'type' => $this->type,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
