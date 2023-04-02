<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'sex' => $this->sex,
            'birthday' => date('Y-m-d', strtotime($this->birthday)),
            'description' => $this->description,
            'path' => ($this->avatar) ? '/storage/images/user/avatar/thumbnail/'.$this->avatar : '',
            'is_online' => $this->isOnline(),
            'created_at' => date('Y-m-d', strtotime($this->created_at)),

        ];
    }
}
