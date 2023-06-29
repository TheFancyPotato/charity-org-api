<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date,
            'amount' => $this->amount,
            'description' => $this->description,
            'family_id' => $this->family_id,
            'family' => $this->whenLoaded('family'),
            'user_id' => $this->user_id,
        ];
    }
}
