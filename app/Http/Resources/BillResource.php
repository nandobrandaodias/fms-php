<?php

namespace App\Http\Resources;

use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->client_id,
            'cliente' => Client::find($this->client_id),
            'billing_id' => $this->billing_id,
            'cost' => $this->cost,
            'reference_month' => $this->reference_month,
            'expiration_date' => $this->expiration_date,
            'created_at' => $this->created_at,
            'is_open' => $this->is_open,
            'payments' => $this->when($this->payments,
                Payment::all()->where('bill_id', $this->id)
            )
        ];
    }
}
