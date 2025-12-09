<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MachineResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'machine_number' => $this->machine_number,
            'machine_name' => $this->machine_name,
            'registration_number' => $this->registration_number,
            'department' => $this->department,
            'production_engineering' => $this->production_engineering,
            'location' => $this->location,
            'type' => $this->type,
            'room' => $this->room,
            'year' => $this->year,
            'status' => $this->status,
            'notes' => $this->notes,
            'latest_checksheet' => new ChecksheetRecordResource($this->whenLoaded('latestChecksheet')),
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }
}

// ===================================

class ChecksheetTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'items' => ChecksheetItemResource::collection($this->whenLoaded('items')),
            'items_count' => $this->when(isset($this->items_count), $this->items_count),
        ];
    }
}