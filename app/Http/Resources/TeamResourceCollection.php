<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TeamResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->keyBy('id')->map(function ($item) {
            // Здесь вы можете определить ключи на основе значений элементов коллекции
            return [$item->id => new TeamResource($item)];
        });
    }
}
