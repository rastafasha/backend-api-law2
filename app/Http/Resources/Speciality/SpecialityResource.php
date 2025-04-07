<?php

namespace App\Http\Resources\Speciality;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialityResource extends JsonResource
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
            "id"=>$this->resource->id,
            "title"=>$this->resource->title,
            "description"=>$this->resource->description,
            "is_active"=>$this->resource->is_active,
            "isFeatured"=>$this->resource->isFeatured,
            "count_profiles"=>$this->resource->count_profiles,
            // "user_id"=>$this->resource->user_id,

            // "user"=>$this->resource->user ? [
            //     "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            //     "user_id" => $this->resource->id,
            //     "surname"=>$this->resource->surname,
            //     "speciality_id" => $this->resource->speciality_id,
                
            // ]:NULL,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : NULL,
            
        ];
    }
}
