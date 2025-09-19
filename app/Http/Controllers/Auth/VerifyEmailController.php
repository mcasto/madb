<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        $user = User::find($id);

        if (!$user) {
            return new JsonResponse([
                'message' => 'User not found'
            ], 404);
        }

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return new JsonResponse([
                'message' => 'Invalid verification link'
            ], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return new JsonResponse([
                'message' => 'Email already verified'
            ], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return new JsonResponse([
            'message' => 'Email verified successfully'
        ], 200);
    }
}
