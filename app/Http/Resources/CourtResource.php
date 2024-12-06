<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourtResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Map Domain Court model values
        return [
            'data' => [
                'name' => $this->getName(),
                'sport' => $this->getSport(),
            ]
        ];
    }
}
