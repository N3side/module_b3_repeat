<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $name = "$this->last_name $this->first_name $this->patronymic";

        return [
            "id" => $this->id,
            "name" => $name,
            "email" => $this->email
        ];
    }
}
