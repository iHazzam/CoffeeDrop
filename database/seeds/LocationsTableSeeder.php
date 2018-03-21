<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;
use App\Location;
use Zttp\Zttp;
class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //read CSV
        $csv = Reader::createFromPath(storage_path('location_data.csv'),'r');
        foreach($csv as $k => $record)
        {
            if($k > 0)
            {
                $locarr = [];
                $locarr['postcode'] = $record['0'];

                $response = Zttp::get('https://api.postcodes.io/postcodes/' . $locarr['postcode'])->json();
                $address = Zttp::get('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $response['result']['latitude'] .  ',' . $response['result']['longitude'])->json();

                $locarr['latitude'] = $response['result']['latitude'];
                $locarr['longitude'] = $response['result']['longitude'];

                try {

                    $locarr['city'] = $address['results'][0]['address_components'][2]['long_name'];
                    $locarr['address_line1'] = $address['results'][0]['address_components'][0]['long_name'];
                    $locarr['address_line2'] = $address['results'][0]['address_components'][1]['long_name'];

                    $loc = Location::create($locarr);

                    for ($i = 1; $i < 15; $i = $i + 2) {
                        $ope = \App\Opening::create([
                            'location_id' => $loc->id,
                            'day' => (($i + 1) / 2) - 1,
                            'opens' => $record[$i],
                            'closes' => $record[$i + 1]
                        ]);
                    }
                }
                catch (\Exception $e)
                {
                    dd($response ,$address);
                }
            }
            sleep(1);//for rate limit
        }


        //geocode

        //Create data

        //Create locations

    }
}
