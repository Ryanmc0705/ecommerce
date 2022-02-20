<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "sub_category_id" => $this->sub_category_id,
            "brand_id" => $this->brand_id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "stocks" => $this->stocks,
        ];
    }
}
