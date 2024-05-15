<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FixtureResource extends JsonResource
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
            'simulationUid' => $this->simulation->uid,
            'week' => $this->week,
            'host' => TeamResource::make($this->host),
            'guest' => TeamResource::make($this->guest),
            'hostGoals' => $this->host_fc_goals,
            'guestGoals' => $this->guest_fc_goals,
            'playedAt' => $this->played_at,
        ];
    }
}
