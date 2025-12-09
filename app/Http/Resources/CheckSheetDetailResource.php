<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecksheetDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'checksheet_record_id' => $this->checksheet_record_id,
            'checksheet_item_id' => $this->checksheet_item_id,
            'item' => new ChecksheetItemResource($this->whenLoaded('item')),
            'check_status' => $this->check_status,
            'check_value' => $this->check_value,
            'remarks' => $this->remarks,
            'image_path' => $this->image_path,
            'image_url' => $this->image_url,
        ];
    }
}