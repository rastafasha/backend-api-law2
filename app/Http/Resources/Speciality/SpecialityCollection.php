<?php

namespace App\Http\Resources\Speciality;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecialityCollection extends ResourceCollection
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
            "data"=> SpecialityResource::collection($this->collection)
        ];
    }
}
