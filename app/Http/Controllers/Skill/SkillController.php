<?php

namespace App\Http\Controllers\skill;

use App\Http\Controllers\ApiController;
use App\Models\Skill;
use App\Transformers\SkillTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SkillController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. SkillTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::all();

        return $this->showAll($skills);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
        ];
        $this->validate($request, $rules);

        $user = Auth::user();


        if($user->isAdmin()) {

            $data = $request->all();
            $skill = Skill::create($data);

            return $this->showOne($skill, Response::HTTP_CREATED);
        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {

        return $this->showOne($skill);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $user = Auth::user();



        if($user->isAdmin()) {

            $skill->fill($request->all());

            if($skill->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $skill->save();
            return $this->showOne($skill);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return $this->showOne($skill);
    }
}
