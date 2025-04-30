<?php

namespace App\Http\Resources\Profile;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            "client_id"=>$this->resource->client_id,
            "speciality_id"=>$this->resource->speciality_id,
            "nombre"=>$this->resource->nombre,
            "surname"=>$this->resource->surname,
            "full_name"=> $this->resource->name.' '.$this->resource->surname,
            "email"=>$this->resource->email,
            "gender"=>$this->resource->gender,
            "n_doc"=>$this->resource->n_doc,
            "direccion"=>$this->resource->direccion,
            "pais"=>$this->resource->pais,
            "lang"=>$this->resource->lang,
            "estado"=>$this->resource->estado,
            "ciudad"=>$this->resource->ciudad,
            "telhome"=>$this->resource->telhome,
            "telmovil"=>$this->resource->telmovil,
            // "redessociales"=>$this->resource->redessociales,
            // "precios"=>$this->resource->precios,
            "redessociales" =>$this->resource->redessociales ? json_decode($this->resource->redessociales) : NULL,
            "precios" =>$this->resource->precios ? json_decode($this->resource->precios) : NULL,
            "status"=>$this->resource->status,
            "rating"=>$this->resource->rating,
            "description"=>$this->resource->description,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            

        ];
    }
}
