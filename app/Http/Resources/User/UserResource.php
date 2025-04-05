<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
       
        return [
            "id"=>$this->resource->id,
            "name"=>$this->resource->name,
            "surname"=>$this->resource->surname,
            "n_doc"=>$this->resource->n_doc,
            "full_name"=> $this->resource->name.' '.$this->resource->surname,
            "email"=>$this->resource->email,
            "password"=>$this->resource->password,
            "rolename"=>$this->resource->rolename,
            "mobile"=>$this->resource->mobile,
            "birth_date"=>$this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y/m/d") : NULL,
            "gender"=>$this->resource->gender,
            "education"=>$this->resource->education,
            "status"=>$this->resource->status,
            "location_id"=>$this->resource->location_id,
            "designation"=>$this->resource->designation,
            "address"=>$this->resource->address,
            // "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            "roles"=>$this->resource->roles->first(),
            "speciality_id" => $this->resource->speciality_id,
            "speciality"=>$this->resource->speciality ? [
                "id"=> $this->resource->speciality->id,
                "name"=> $this->resource->speciality->name,
            ]:NULL,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : NULL,
            
        ];
    }
}
