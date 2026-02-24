<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return the authenticated user as JSON.
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}

