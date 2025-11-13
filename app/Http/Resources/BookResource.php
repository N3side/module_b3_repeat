<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GenreResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "title" => $this->title,
            "preview" => url($this->preview),
            "authors" => $this->authors->map(function ($author) {
                return [
                    "id" => $author->id
                ];
            }),
            "genres" => $this->genres->map(function ($genre) {
                return [
                    "id" => $genre->id
                ];
            }),
            "price" => $this->price,
        ];
    }
}
