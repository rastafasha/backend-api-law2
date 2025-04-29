<?php

namespace App\Http\Resources\Client;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            "nombre"=>$this->resource->nombre,
            "username"=>$this->resource->username,
            "email"=>$this->resource->email,
            "password"=>$this->resource->password,
            "rolename"=>$this->resource->rolename,
            // "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            "roles"=>$this->resource->roles->first(),
            "profile"=>$this->resource->speciality ? [
                "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
                "user_id" => $this->resource->id,
                "surname"=>$this->resource->surname,
                "n_doc"=>$this->resource->n_doc,
                "full_name"=> $this->resource->nombre.' '.$this->resource->surname,
               
                "mobile"=>$this->resource->mobile,
                "birth_date"=>$this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y/m/d") : NULL,
                "gender"=>$this->resource->gender,
                "status"=>$this->resource->status,
                "direccion"=>$this->resource->direccion,
                "description"=>$this->resource->description,
            ]:NULL,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : NULL,
            
        ];
    }
}
