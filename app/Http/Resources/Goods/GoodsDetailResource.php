<?php

namespace App\Http\Resources\Goods;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $data['imgs'] = $this->imgs->pluck('img')->toArray();
        $data['pics'] = $this->pics->pluck('pic');

        return $data;
    }
}
