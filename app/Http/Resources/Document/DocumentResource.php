<?php

namespace App\Http\Resources\Document;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->resource-> id,
            'user_id'=>$this->resource->user_id,
            'client_id'=>$this->resource->client_id,
            'name_file'=> $this->resource->name_file,
            'name_category'=> $this->resource->name_category,
            'size'=> $this->resource->size,
            'resolution'=> $this->resource->resolution,
            'file'=> env("APP_URL")."storage/".$this->resource->file,
            // 'file'=> env("APP_URL").$this->resource->file,
            'type'=> $this->resource->type,
           
        ];
    }
}