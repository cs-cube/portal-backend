<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'code' => $this->code,
            'no_of_years' => $this->no_of_years,
            'department_id' => $this->department_id,
            'student_count' => $this->students()->count(),
            'students' => $this->whenLoaded('students'),
            'department' => $this->whenLoaded('department')
        ];
    }
}
