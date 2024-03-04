<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Constants;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalAmount = 0;

        foreach ($this->saleProducts as $saleProduct) {
            $totalAmount += $saleProduct->product->price * $saleProduct->amount;
        }

        $returnArray = [
            'sales_id' => $this->id,
            'amount' => $totalAmount,
            'status' => Constants::STATUS_TEXT[$this->status ?? 1]
        ];

        if ($this->saleCancels->isNotEmpty()) {
            $returnArray['reason_cancel'] = $this->saleCancels;
        }

        $returnArray['products'] = SaleProductResource::collection(
            $this->saleProducts)->map->toCustomArray(request()
        );

        return $returnArray;
    }
}
