<?php

namespace App\Http\Resources\Favorite;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data"=> FavoriteResource::collection($this->collection)
        ];
    }
}
