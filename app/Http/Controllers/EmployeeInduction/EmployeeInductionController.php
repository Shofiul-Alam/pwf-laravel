<?php

namespace App\Http\Controllers\EmployeeInduction;

use App\Models\EmployeeInduction;
use App\Transformers\EmployeeInductionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeInductionController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->except(['resend', 'verify']);

        $this->middleware('transform.input:'. EmployeeInductionTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeInductions = EmployeeInduction::all();

        return $this->showAll($employeeInductions);

//        return response()->json($employeeInductions, 200);
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
            'form_id' => 'required',
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
        $data = $request->all();



        if(isset($data['employee_id']) && $user->isAdmin()){
            $data['employee_id'] = $data['employee_id'];
        } else {
            if($user->employee) {
                $data['employee_id'] = $user->employee->id;
            } else {
                return response()->json(['error' => 'Unauthorize Access',
                    'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
            }

        }


        $employeeInduction = EmployeeInduction::create($data);

        return $this->showOne($employeeInduction, Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeInduction $employeeInduction)
    {
        return $this->showOne($employeeInduction);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeInduction $employeeInduction)
    {
        $user = Auth::user();

        $authenticatedEmployeeInductionId = $user->employeeInduction->id;


        if($employeeInduction->id == $authenticatedEmployeeInductionId || $user->isAdmin()) {

            $employeeInduction->fill($request->all());

            if($employeeInduction->isClean()) {

                    return response()->json(['error' => 'You need to specify a different value to update',
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $employeeInduction->save();
            return $this->showOne($employeeInduction);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeInduction $employeeInduction)
    {
        $employeeInduction->delete();
        return $this->showOne($employeeInduction);
    }
}
