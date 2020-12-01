<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
                "id" => $this->id,
                "name" => $this->name,
                "email" => $this->email,
                //"email_verified_at" => $this->null,
               // "current_team_id" => $this->null,
                //"profile_photo_path" => $this->null,
                "company_id" => $this->company_id,
                "isManager" => $this->isManager,
                "isAdmin" => (boolean)$this->isAdmin,
                "created_at" => $this->created_at->format('Y-m-d h:m'),
                "updated_at" => $this->updated_at->format('Y-m-d h:m'),
               // "profile_photo_url" => $this->"https://ui-avatars.com/api/?name=Souad&color=7F9CF5&background=EBF4FF"
        ];
    }
}
