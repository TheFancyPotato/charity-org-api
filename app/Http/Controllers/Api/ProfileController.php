<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function details()
    {
        return new UserResource(auth()->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        if ($request->current_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'message' => 'The current password is not correct.',
                ], 422);
            }

            $data['password'] = Hash::make($request->password);
        }

        $user->update(array_filter($data, fn ($item) => $item != null));

        return new UserResource($user);
    }
}
