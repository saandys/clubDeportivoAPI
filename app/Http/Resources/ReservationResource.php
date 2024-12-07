<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Map Domain Reservation model values
        return [
            'data' => [
                'court' => $this->getCourt(),
                'member' => $this->getMember(),
                'date' => $this->getDate(),
                'start_time' => $this->getStartTime(),
                'end_time' => $this->getEndTime(),
            ]
        ];
    }
}
