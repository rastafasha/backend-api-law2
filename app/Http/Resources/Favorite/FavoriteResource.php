<?php

namespace App\Http\Resources\Favorite;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
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
            "user_id"=>$this->resource->user_id,
            "cliente_id"=>$this->resource->cliente_id,
            "profile"=>$this->resource->profile ? [
                "id"=>$this->resource->profile->user_id,
                "user_id"=>$this->resource->profile->user_id,
                "nombre"=>$this->resource->profile->nombre,
                "surname"=>$this->resource->profile->surname,
                "email"=>$this->resource->user->email,
                "speciality_id"=>$this->resource->profile->speciality_id,
                "speciality"=>$this->resource->profile->speciality ? [
                    "id"=>$this->resource->profile->speciality_id,
                    "title"=>$this->resource->profile->speciality->title,
                   
                ]:NULL,

                // "n_doc"=>$this->resource->n_doc,
                "rating"=>$this->resource->profile->rating,
                "avatar"=> $this->resource->profile->avatar ? env("APP_URL")."storage/".$this->resource->profile->avatar : null,
                // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            
            ]:NULL,
            
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            

        ];
    }
}
