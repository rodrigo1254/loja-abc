<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    protected $amount;

    public function __construct($resource, $amount = null)
    {
        parent::__construct($resource);
        $this->amount = $amount;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'product_id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];

        if ($this->amount !== null) {
            $data['amount'] = $this->amount;
        }

        return $data;
    }

    public function toCustomArray()
    {
        return [
            'product_id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}
