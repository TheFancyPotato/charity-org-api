<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', City::class);

        return CityResource::collection(
            City::query()->withCount('families')->paginate(
                perPage: request('perPage'),
                page: request('page'),
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        $city = City::create($request->validated());

        return (new CityResource($city))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        $this->authorize('view', $city);

        return new CityResource($city);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->validated());

        return (new CityResource($city));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $this->authorize('delete', $city);

        if ($city->families()->count() > 0) {
            return response()->json([
                'message' => 'This city already has families. You cannot delete this city.',
            ], 400);
        }

        $city->delete();

        return response(status: 204);
    }
}
