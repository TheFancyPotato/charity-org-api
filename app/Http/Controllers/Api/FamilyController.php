<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Family\StoreFamilyRequest;
use App\Http\Requests\Family\UpdateFamilyRequest;
use App\Http\Resources\FamilyResource;
use App\Models\Family;
use Illuminate\Support\Facades\Storage;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Family::class);

        $search = request('search', '');
        $sorting = request('sorting', []);
        $filters = request('filters', []);
        $perPage = request('perPage', 25);

        return FamilyResource::collection(
            Family::query()
                ->applySearch($search)
                ->applyFilters($filters)
                ->applySorting($sorting)
                ->paginate(perPage: $perPage)
                ->withQueryString(),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request)
    {
        $family = Family::create($request->validated());

        if ($request->has('docs')) {
            $docs = [];

            foreach ($request->docs as $doc) {
                $path = $family->id . '-' . date('Ymdis') . '-' . uniqid() . '.' . $doc->extension();
                $docs[] = $path;

                Storage::put($path, file_get_contents($doc));
            }

            $family->update([
                'docs' => $docs,
            ]);
        }

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

        if ($request->has('docs')) {
            $docs = [];

            foreach ($request->docs as $doc) {
                $path = $family->id . '-' . date('Ymdis') . '-' . uniqid() . '.' . $doc->extension();
                $docs[] = $path;

                Storage::put($path, file_get_contents($doc));
            }

            $family->update([
                'docs' => $docs,
            ]);
        }

        return (new FamilyResource($family))->response()->setStatusCode(200);
    }

    /**
     * Move the specified resource to trash.
     */
    public function destroy(Family $family)
    {
        $this->authorize('delete', $family);

        $family->delete();

        return response(status: 204);
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $family)
    {
        $family = Family::onlyTrashed()->findOrFail($family);

        $this->authorize('restore', $family);

        $family->restore();

        return response(status: 204);
    }


    /**
     * Delete the specified resource from storage.
     */
    public function forceDelete($family)
    {
        return response(status: 501);
    }
}
