<?php

/**
 * Created by PhpStorm.
 * User: Harry
 * Date: 26/02/2018
 * Time: 08:32
 */
namespace App\Repositories;

use App\Location;
use App\Repositories\Contracts\LocationRepository;
use App\Repositories\RepositoryAbstract;
use Zttp\Zttp;
use Illuminate\Support\Facades\Log;
class LocationRepositoryImpl extends RepositoryAbstract implements LocationRepository
{

    public function entity()
    {
        return Location::class;
    }

    public function create(array $properties)
    {

            $locarr = [];
            $locarr['postcode'] = $properties['record']['0'];

            $resp = $this->geocode($locarr['postcode']);
            $address = Zttp::get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $resp['lat'] .  ',' . $resp['lng'] . '&key=' . config('env.googlemaps_key'))->json();

            $locarr['latitude'] = $resp['lat'];
            $locarr['longitude'] = $resp['lng'];

            try {

                $locarr['city'] = $address['results'][0]['address_components'][2]['long_name'];
                $locarr['address_line1'] = $address['results'][0]['address_components'][0]['long_name'];
                $locarr['address_line2'] = $address['results'][0]['address_components'][1]['long_name'];

                $loc = Location::create($locarr);

                for ($i = 0; $i < 7; $i++) {
                    $ope = \App\Opening::create([
                        'location_id' => $loc->id,
                        'day' => $i,
                        'opens' => $properties['record'][$i+1],
                        'closes' => $properties['record'][$i + 8]
                    ]);
                }
            }
            catch (\Exception $e)
            {
               dd($e);
            }
    }

    public function haversearch($lat, $lng, $radius = 1000)
    {
        $closest = Location::select('*')
            ->selectRaw('( 3959 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance', [$lat, $lng, $lat])
            ->havingRaw("distance < ?", [$radius])->orderBy('distance')
            ->first();
        return $closest;
    }




    public function geocode($postcode)
    {
        try{
            $response = Zttp::get('https://api.postcodes.io/postcodes/' .$postcode)->json();
            $resp['lat'] = $response['result']['latitude'];
            $resp['lng'] = $response['result']['longitude'];
            return $resp;
        }
        catch(\Exception $e)
        {
            return null;
        }

    }


}