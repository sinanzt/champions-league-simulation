<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StandingResource extends JsonResource
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
            'team' => TeamResource::make($this->team),
            'points' => $this->points,
            'played' => $this->played,
            'won' => $this->won,
            'lost' => $this->lost,
            'draw' => $this->draw,
            'goal_difference' => $this->goal_difference,
            'winChance' => $this->winChance,
        ];
    }
}
