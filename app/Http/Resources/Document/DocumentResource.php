<?php

namespace App\Http\Resources\Document;

use Carbon\Carbon;
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
            'name_file'=> $this->resource->name_file,
            'user_id'=> $this->resource->user_id,
            'client_id'=> $this->resource->client_id,
            'name_category'=> $this->resource->name_category,
            'size'=> $this->resource->size,
            'resolution'=> $this->resource->resolution,
            'file'=> env("APP_URL")."storage/".$this->resource->file,
            'type'=> $this->resource->type,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : NULL,
            "updated_at"=>$this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->format("Y/m/d") : NULL
           
        ];
    }
}