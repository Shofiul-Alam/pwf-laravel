<?php

namespace App\Http\Controllers\Qualification;

use App\Http\Controllers\ApiController;
use App\Models\Qualification;
use App\Transformers\QualificationTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class QualificationController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. QualificationTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qualifications = Qualification::all();

        return $this->showAll($qualifications);
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
            'employee_id' => 'required',
            'skill_id' => 'required',
        ];
        $this->validate($request, $rules);

        $data = $request->all();

        $user = Auth::user();

        $authenticatedEmployeeId = false;

        if($user->employee) {
            $authenticatedEmployeeId = $user->employee->id;
        }


        if($authenticatedEmployeeId || $user->isAdmin()) {



            if(isset($data['employee_id']) && $authenticatedEmployeeId == $data['employee_id'] || isset($data['employee_id']) && $user->isAdmin()) {
                $qualification = Qualification::create($data);
            } else {
                $data['employee_id'] = $authenticatedEmployeeId;
                $qualification = Qualification::create($data);
            }


            return $this->showOne($qualification, Response::HTTP_CREATED);
        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function show(Qualification $qualification)
    {

        return $this->showOne($qualification);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qualification $qualification)
    {
        $data = $request->all();

        $user = Auth::user();

        $authenticatedEmployeeId = false;

        if($user->employee) {
            $authenticatedEmployeeId = $user->employee->id;
        }


        if($qualification->employee->id == $authenticatedEmployeeId || $user->isAdmin()) {

            $qualification->fill($request->all());

            if($qualification->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $qualification->save();
            return $this->showOne($qualification);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualification $qualification)
    {
        $qualification->delete();

        return $this->showOne($qualification);
    }
}
