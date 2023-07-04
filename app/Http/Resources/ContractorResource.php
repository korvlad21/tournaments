<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractorResource extends JsonResource
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
            'id' => $this->id,
            'INN' => $this->INN,
            'KPP' => $this->KPP,
            'name' => $this->name,
            'field_of_activity' => $this->field_of_activity,
            'description' => $this->description,
            'path' => ($this->logo) ? '/storage/images/contractor/logo/thumbnail/'.$this->logo : '',
            'contact' => $this->contact,
        ];
    }
}
