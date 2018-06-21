<?php

namespace App\Http\Resources;

use App\Opening;
use Illuminate\Http\Resources\Json\Resource;

class LocationResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $days = array_flip(config('enums.days'));
        $openings = $this->openings->map(function($obj) use ($days){
            if($obj->opens != null)
            {
                return ['day'=>$days[$obj->day],'open'=>$obj->opens,'closed'=>$obj->closes];
            }
            else{
                return ['day' => $days[$obj->day],'open'=>'CLOSED','closed'=>'CLOSED'];
            }
        });


        return [
            'location' => $this->city,
            'address' => [
                'line1' => $this->address_line1,
                'line2' => $this->address_line2,
                'city' => $this->city,
                'postcode' => $this->postcode
            ],
            'coordinates' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'distance' => round($this->distance, 1) . " Miles",
            'openings' => $openings
        ];
    }
}
