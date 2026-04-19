<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class OpenSearchController extends Controller
{
    public function search(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = $request->input('keyword');
        $posts = Post::where('title', 'LIKE', '%' . $keyword . '%')->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
}
