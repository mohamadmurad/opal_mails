<?php

namespace App\Http\Resources;



use Illuminate\Http\Resources\Json\JsonResource;


class ReceiptsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
       // $obj = new I18N_Arabic('Numbers');

       // $amountText = $obj->int2str($this->amount);
        return [

            'id' => $this->id,
            'recipient_name' => $this->recipient_name,
            'amount' => $this->amount,
           // 'amountText' => $amountText,
            'reason' => $this->reason,
            'status' => (boolean)$this->status,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'company' => new CompanyResource($this->whenLoaded('company')),
            'manager' => new EmployeeResource($this->whenLoaded('manager')),
            'notes' => $this->notes,
            'created_at' => $this->created_at->format('Y-m-d h:m'),
            'updated_at' => $this->updated_at->format('Y-m-d h:m'),
        ];
    }
}
