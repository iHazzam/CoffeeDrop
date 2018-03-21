<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;
use App\Location;
use Zttp\Zttp;
class LocationsTableSeeder extends Seeder
{
    protected $repository;
    public function __construct(\App\Repositories\Contracts\LocationRepository $repository)
    {
        $this->repository = $repository;
    }

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
                $properties=[];
                $properties['record'] = $record;
                $properties['counter'] = $k;
                $this->repository->create($properties);
            }
            sleep(1);//for rate limit
        }


        //geocode

        //Create data

        //Create locations

    }
}
