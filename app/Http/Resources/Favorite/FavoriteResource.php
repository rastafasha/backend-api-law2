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
            // "user_id"=>$this->resource->user_id,
            "user"=>$this->resource->user ? [
                "id"=>$this->resource->user_id,
                "username"=>$this->resource->user->username,
                "email"=>$this->resource->user->email,
                // "n_doc"=>$this->resource->n_doc,
                // "phone"=>$this->resource->phone,
                // "avatar"=> $this->resource->user->avatar ? env("APP_URL")."storage/".$this->resource->user->avatar : null,
                // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            
            ]:NULL,
            "cliente_id"=>$this->resource->cliente_id,
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            

        ];
    }
}
