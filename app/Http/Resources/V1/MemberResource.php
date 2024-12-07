<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Map Domain Member model values
        return [
            'data' => [
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'phone' => $this->getPhone(),
            ]
        ];
    }
}
