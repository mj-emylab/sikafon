<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestLogResource extends JsonResource
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
            'app_id' => $this->app_id,
            'uuid' => $this->uuid,
            'request_status' => $this->request_status,
            'request_id' => $this->request_id,
            'payload' => $this->payload,
            'response' => $this->response,
            'error_message' => $this->error_message,
            'logable_type' => $this->logable_type,
            'logable_id' => $this->logable_id,
            'type' => $this->type,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
