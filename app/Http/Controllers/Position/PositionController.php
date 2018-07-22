<?php

namespace App\Http\Controllers\position;

use App\Http\Controllers\ApiController;
use App\Models\Position;
use App\Transformers\PositionTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PositionController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. PositionTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();

        return $this->showAll($positions);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();


        if($user->isAdmin()) {

            $rules = [
                'name' => 'required',
            ];

            $this->validate($request, $rules);

            $data = $request->all();


            $position = Position::create($data);
            return $this->showOne($position, Response::HTTP_CREATED);

        } else {
            return $this->unauthorizedAccess();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {

        return $this->showOne($position);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $user = Auth::user();


        if($user->isAdmin()) {

            $position->fill($request->all());

            if($position->isClean()) {

                return $this->changeDataToUpdate();
            }
            $position->save();

            return $this->showOne($position);
        } else {
            return $this->unauthorizedAccess();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return $this->showOne($position);
    }
}
