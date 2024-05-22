<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class  ContactTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $tags = Tag::where('name', 'like', '%'.$request->search.'%' )
            ->whereHas('contacts')
            ->paginate(20);

        return response()->json(
            $tags->map(function ($tag){
                return $tag->name;
            })
        );
    }


}
