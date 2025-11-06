<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class HuntingBookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tour_name' => $this->tour_name,
            'hunter_name' => $this->hunter_name,
            'date' => optional($this->date)->format('Y-m-d'),
            'participants_count' => (int) $this->participants_count,
            'guide' => [
                'id' => $this->guide->id,
                'name' => $this->guide->name,
                'experience_years' => (int) $this->guide->experience_years,
            ],
        ];
    }
}
