<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return UserResource::collection(
            User::query()->select('id', 'name', 'username', 'role')->paginate(
                perPage: request('perPage'),
                page: request('page'),
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->tokens()->delete();
        $user->delete();

        return response(status: 204);
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $user)
    {
        $user = User::onlyTrashed()->findOrFail($user);

        $this->authorize('restore', $user);

        $user->restore();

        return response(status: 204);
    }


    /**
     * Delete the specified resource from storage.
     */
    public function forceDelete($user)
    {
        return response(status: 501);
    }
}
