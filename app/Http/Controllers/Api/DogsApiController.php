<?php

namespace App\Http\Controllers\Api;

use App\Apis\DogsApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreedParkRequest;
use App\Models\Breed;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class DogsApiController extends Controller
{
    private DogsApi $api;

    public function __construct(DogsApi $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if($cachedBreed = Redis::get('all_breeds')) {
            return json_decode($cachedBreed, FALSE);
        }

        $allBreeds =  $this->api->getAllBreeds();

        if (array_key_exists('message', $allBreeds)) {
            Redis::set('all_breeds',  json_encode($allBreeds['message']));
            return $allBreeds['message'];
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id = null)
    {
        $allBreeds =  $this->api->getAllBreeds();

        if(!$id){
            $id = array_rand($allBreeds['message']);
        }

        if($cachedBreed = Redis::get('breeds__' . $id)) {
            return response([
                'data' => json_decode($cachedBreed, FALSE),
                'source' => 'cache'
            ], 200) ;
        }

        if (array_key_exists($id, $allBreeds['message'])) {

            $breed = Breed::with(['users', 'parks'])->firstOrCreate(
                ['name' => $id],
                ['sub_breeds' => $allBreeds['message'][$id]]
            );

            Redis::set('breeds__' . $id, $breed);

            return response(['data' => $breed, 'source' => 'db'], 200) ;
        }

    }

    /**
     * Display the image of resource.
     *
     * @param  int  $id
     */
    public function image($id)
    {
        return $this->api->randomImage($id);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $breed = Breed::where('name', $id)->first();

        if($breed){
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'sub_breeds' => 'array'
            ]);

            $breed->update($validated);
            return response(['data' => $breed, 'source' => 'db'], 200) ;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $breed = Breed::where('name', $id)->first();

        if($breed){
            $breed->delete();
        }
    }

     public function associatePark(BreedParkRequest $request, $park_id)
    {

        $park = Park::find($park_id);
        $breed = Breed::where('name', $request->input('breed_id'))->first();

        if($park && $breed) {
            $breed->parks()->save($breed);
            return response('breed assigned to park', 200);
        }

    }
}
