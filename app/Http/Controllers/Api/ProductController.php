<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * List Todos for only the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = Product::where('user_id', auth()->user()->id)->get();
        return response()->json($todos, 200);
    }

    public function show($id)
    {
        $todos = Product::where([
            'id' => $id,
            'user_id' => auth()->user()->id
        ])->first();
        return response()->json($todos, 200);
    }

    /**
     * Create a new Todo for the authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'photo' => 'required',
            'manufactured_year' => ['required']
        ]);

        if ($request->photo_locator) {
            $file = base64_decode($request['photo']);
            $folderName = 'public/uploads/';
            $safeName = $request->photo_locator;
            $destinationPath = public_path() . $folderName;
            $success = file_put_contents(public_path().'/uploads/'.$safeName, $file);
        }


        $todo = Product::create([
            'name' => $request->name,
            'photo' => $request->photo_locator,
            'user_id' => auth()->user()->id,
            'manufactured_year' => $request->manufactured_year
        ]);

        return response()->json($todo, 201);
    }

    /**
     * Update a Todo for the authenticated user
     *
     * @param $todoId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($todoId, Request $request)
    {
        $todo = Product::find($todoId);

        $todo->name = $request->name;
        $todo->manufactured_year = $request->manufactured_year;

        if ($request->photo_locator) {
            $file = base64_decode($request['photo']);
            $folderName = 'public/uploads/';
            $safeName = $request->photo_locator;
            $destinationPath = public_path() . $folderName;
            $success = file_put_contents(public_path().'/uploads/'.$safeName, $file);
        }

        $todo->photo = $request->photo_locator ?? $todo->photo;
        $todo->save();

        return response()->json($todo, 200);
    }

    /**
     * Delete a Todo for the authenticated user
     *
     * @param Request $request
     * @param $todoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($todoId)
    {
        Product::destroy($todoId);
        return response()->json([], 200);
    }
}
