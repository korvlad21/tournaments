<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
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
            'number' => $this->number,
            'name' => $this->name,
            'type' => $this->type,
            'count_teams' => $this->count_teams,
            'count_group' => $this->count_group,
            'count_games' => $this->count_games,
            'current_count_teams' => $this->stageTeams->count(),
        ];
    }
}
