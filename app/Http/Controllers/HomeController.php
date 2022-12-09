<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'user' => auth('user-api')->check(),
            'admin' => auth('admin-api')->check(),
        ]);
    }
}
