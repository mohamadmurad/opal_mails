<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FilesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'path' => asset('files/'.$this->name),
            'created_at' => $this->created_at->format('Y-m-d h:m'),
            'updated_at' => $this->updated_at->format('Y-m-d h:m'),

        ];
    }
}
