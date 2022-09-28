<?php

namespace Modules\Map\Http\Controllers;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SetupGuide\Entities\SetupGuide;
use Illuminate\Contracts\Support\Renderable;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('map::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('map::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('map::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('map::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $setting = Setting::first();

        if ($request->from_preference) {

            $request->validate([
                'map_type' => 'required'
            ]);

            if ($request->map_type == 'google-map') {
                $request->validate([
                    'google_map_key' => 'required',
                ]);
            } else {
                $request->validate([
                    'map_box_key' => 'required',
                ]);
            }

            if ($request->map_type == 'google-map') {
                $setting->update([
                    'default_map' => $request->map_type,
                    'google_map_key' => $request->google_map_key,
                ]);
            } else {
                $setting->update([
                    'default_map' => $request->map_type,
                    'map_box_key' => $request->map_box_key,
                ]);
            }
        } else {
            $request->validate([
                'map_type' => 'required',
                'default_long' => 'required',
                'default_lat' => 'required',
            ]);

            if ($request->map_type == 'google-map') {
                $request->validate([
                    'google_map_key' => 'required',
                ]);
            } else {
                $request->validate([
                    'map_box_key' => 'required',
                ]);
            }

            $setting->update([
                'default_map' => $request->map_type,
                'default_long' => $request->default_long,
                'default_lat' => $request->default_lat,
            ]);
            if ($request->map_type == 'google-map') {
                $setting->update([
                    'google_map_key' => $request->google_map_key,
                ]);
            } else {
                $setting->update([
                    'map_box_key' => $request->map_box_key,
                ]);
            }
        }

        SetupGuide::where('task_name', 'map_setting')->update(['status' => 1]);
        flashSuccess('Map data updated !');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }


    public function getLocation(Request $request)
    {

        $address =$this->getAddress($request->lat,$request->lng,$request->key);

        $address['lat']=$request->lat;
        $address['lng']=$request->lng;

        $location=$request->session()->put('location', $request->input());
        return response()->json([$address,$location]);

    }









    function getAddress($latitude, $longitude,$key)
    {




        if (!empty($latitude) && !empty($longitude)) {
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=true_or_false&key='.$key);
            $output = json_decode($geocodeFromLatLong);



            //Get address from json data
            $address = array(
                'country' => $this->google_getCountry($output),
                'place' => $this->google_getProvince($output),
                'district' => $this->google_getCity($output),
                'region' => $this->google_getStreet($output),
                'postcode' => $this->google_getPostalCode($output),
                'address' => $this->google_getAddress($output),


            );





            if (!empty($address)) {
                return $address;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    function google_getCountry($jsondata)
    {
        return $this->Find_Long_Name_Given_Type("country", $jsondata->results[0]->address_components);
    }
    function google_getProvince($jsondata)
    {
        return $this->Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata->results[0]->address_components, true);
    }
    function google_getCity($jsondata)
    {
        return $this->Find_Long_Name_Given_Type("locality", $jsondata->results[0]->address_components);
    }
    function google_getStreet($jsondata)
    {
        return $this->Find_Long_Name_Given_Type("street_number", $jsondata->results[0]->address_components) . ' ' . $this->Find_Long_Name_Given_Type("route", $jsondata->results[0]->address_components);
    }
    function google_getPostalCode($jsondata)
    {
        return $this->Find_Long_Name_Given_Type("postal_code", $jsondata->results[0]->address_components);
    }

    function google_getAddress($jsondata)
    {
        return $jsondata->results[0]->address_components[1]->long_name;
    }




    function Find_Long_Name_Given_Type($type, $array, $short_name = false)
    {


        foreach ($array as $value) {

            if (in_array($type, $value->types)) {
                if ($short_name)
                    return $value->short_name;
                return $value->long_name;
            }
        }
    }
}
