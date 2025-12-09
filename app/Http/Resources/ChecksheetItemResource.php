<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecksheetItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'checksheet_type_id' => $this->checksheet_type_id,
            'item_number' => $this->item_number,
            'item_name' => $this->item_name,
            'check_method' => $this->check_method,
            'standard' => $this->standard,
            'tool' => $this->tool,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
    }
}