<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            'user_id' => $this->user,
            'user' => User::find($this->user_id),
            'reference_month' => $this->reference_month,
            'created_at' => $this->created_at,
            'is_approved' => $this->is_approved,
            'bills' => BillResource::collection($this->bills)
        ];
    }
}
