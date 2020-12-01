<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => asset('logo/'.$this->logo),
            'created_at' => $this->created_at->format('Y-m-d h:m'),
            'updated_at' => $this->updated_at->format('Y-m-d h:m'),

        ];
    }
}
