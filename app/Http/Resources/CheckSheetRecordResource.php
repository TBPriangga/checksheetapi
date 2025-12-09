<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecksheetRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'machine_id' => $this->machine_id,
            'machine' => new MachineResource($this->whenLoaded('machine')),
            'checksheet_type_id' => $this->checksheet_type_id,
            'checksheet_type' => new ChecksheetTypeResource($this->whenLoaded('checksheetType')),
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'leader_id' => $this->leader_id,
            'leader' => new UserResource($this->whenLoaded('leader')),
            'foreman_id' => $this->foreman_id,
            'foreman' => new UserResource($this->whenLoaded('foreman')),
            'supervisor_id' => $this->supervisor_id,
            'supervisor' => new UserResource($this->whenLoaded('supervisor')),
            'check_date' => optional($this->check_date)->format('Y-m-d'),
            'check_day' => $this->check_day,
            'check_month' => $this->check_month,
            'check_year' => $this->check_year,
            'work_hours' => $this->work_hours,
            'status' => $this->status,
            'notes' => $this->notes,
            'technician_notes' => $this->technician_notes,
            'details' => ChecksheetDetailResource::collection($this->whenLoaded('details')),
            'submitted_at' => optional($this->submitted_at)->toISOString(),
            'approved_at' => optional($this->approved_at)->toISOString(),
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }
}