<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Location;
use App\Repositories\Contracts\LocationRepository;
use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
class LocationController extends Controller
{
    protected $repo;
    public function __construct(LocationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
        return LocationResource::collection($this->repo->paginate(5));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        $days = array_flip(config('enums.days'));
        //format data into correct format
        $properties = [];
        $properties['record'][0] = $request->postcode;

        for($i = 1; $i < 8; $i++)
        {
            $day = $days[$i-1];
            if(array_key_exists($day, $request->opening_times))
            {
                $properties['record'][$i] = $request->opening_times[$day];
                $properties['record'][$i+7] = $request->closing_times[$day];
            }
            else{
                $properties['record'][$i] = "00:00";
                $properties['record'][$i+7] = "00:00";
            }
        }
        $resp = $this->repo->create($properties);
        return response()->json(true);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
       $postcode = $request->postcode;
       if($postcode == null)
       {
           return response()->json('No Postcode Entered');
       }
       $geo = $this->repo->geocode($postcode);
       if($geo == null)
       {
           return response()->json('Postcode not geocoded');
       }
       $closest = $this->repo->haversearch($geo['lat'],$geo['lng']);
       return new LocationResource($closest);

    }
}
