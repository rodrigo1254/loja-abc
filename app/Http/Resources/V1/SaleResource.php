<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\DB;

use App\Models\Sale;

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

        //calculando total
        foreach ($this->saleProducts as $saleProduct) {
            $totalAmount += $saleProduct->product->price * $saleProduct->amount;
        }

        return [
            'sales_id' => $this->id,
            'amount' => $totalAmount,
            'products' => SaleProductResource::collection($this->saleProducts)->map->toCustomArray(request())
        ];
    }
}
