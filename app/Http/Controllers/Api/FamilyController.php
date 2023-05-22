<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Family\StoreFamilyRequest;
use App\Http\Requests\Family\UpdateFamilyRequest;
use App\Http\Resources\FamilyResource;
use App\Models\Family;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Family::class);

        return FamilyResource::collection(
            Family::query()->paginate(
                perPage: request('per_page'),
                page: request('page'),
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request)
    {
        $family = Family::create($request->validated());

        return (new FamilyResource($family))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        $this->authorize('view', $family);

        return new FamilyResource($family);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyRequest $request, Family $family)
    {
        $family->update($request->validated());

        return (new FamilyResource($family))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        $this->authorize('delete', $family);

        $family->delete();

        return response()->json([
            'message' => 'Family deleted successfully.',
        ]);
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $family)
    {
        $family = Family::onlyTrashed()->findOrFail($family);

        $this->authorize('restore', $family);

        $family->restore();

        return response()->json([
            'message' => 'Family restored successfully.',
        ]);
    }


    /**
     * Restore the specified resource from trash.
     */
    public function forceDelete($family)
    {
        $family = Family::onlyTrashed()->findOrFail($family);

        $this->authorize('delete', $family);

        $family->restore();

        return response()->json([
            'message' => 'Family force deleted successfully.',
        ]);
    }
}
