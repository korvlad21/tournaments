<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TournamentStageResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'count_teams' => $this->count_teams,
            'current_count_teams' => $this->tournamentTeams->count(),
            'status' => $this->status,
            'stages' => ($this->stages) ? StageResource::collection($this->stages) : null
        ];
    }
}
