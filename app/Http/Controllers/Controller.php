<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function ApiHome(){
        return response()->json([
            'message' => "Welcome to Sujeet Kushwaha's API Wonderland! Dive in and explore the magic of seamless integration.",
        ]);
    }
}
