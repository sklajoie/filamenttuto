<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
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
            'id'=>$this->id,
            'firstName'=>$this->first_name,
            'lastName'=>$this->last_name,
            'address'=>$this->address,
            'zipCode'=>$this->zip_code,
            'countryId'=>$this->country_id,
            'cityId'=>$this->city_id,
            'departmentID'=>$this->department_id,
            'birthDate'=>$this->birth_date,
            'dateHired'=>$this->date_hired,
        ];
    }
}
