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
        parent::setImageRoot();
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInductionsByEmployee(Request $request)
    {

        $user = Auth::user();

        $authenticatedEmployeeId = false;
        $employeeId = $request->input('employee');

        if($user->employee && $authenticatedEmployeeId == $employeeId) {
            $authenticatedEmployeeId = $user->employee->id;
        }

        if($authenticatedEmployeeId || $user->isAdmin()) {
            $orderBy = EmployeeInductionTransformer::originalAttribute(
                $request->input('orderBy')
            );
            $sort = $request->input('sort');

            switch ($sort) {
                case 'asc': $inductions = EmployeeInduction::all()->where('employee_id', $employeeId)->sortBy($orderBy);
                    break;
                case 'desc': $inductions = EmployeeInduction::all()->where('employee_id', $employeeId)->sortByDesc($orderBy);
                    break;
                default: $inductions = EmployeeInduction::all()->where('employee_id', $employeeId);
                    break;

            }


            return $this->showAll($inductions);
        } else {
            return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }


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
            'form_id' => 'required',
            'image'=>'image|mimes:jpg,png,jpeg|max:10240'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
        $data = $request->all();

        $authenticatedEmployeeId = false;

        if($user->employee) {
            $authenticatedEmployeeId = $user->employee->id;
        }

        if($authenticatedEmployeeId || $user->isAdmin()) {
            if(isset($request->image)) {
                $data['induction_file_name'] = $request->image->store('');
                $data['induction_file_url'] = $this->imageRoot. '/img/' . $data['induction_file_name'];
                $data['induction_file_type'] = $request->image->getMimeType();
                $data['induction_file_size'] = number_format($request->image->getSize()/1024/1024, 2) . "MB";
            }

            if(isset($data['employee_id']) && $authenticatedEmployeeId == $data['employee_id'] || isset($data['employee_id']) && $user->isAdmin()) {
                $data['employee_id'] = $data['employee_id'];

            } else {
                if($user->employee) {
                    $data['employee_id'] = $user->employee->id;
                } else {
                    return response()->json(['error' => 'Unauthorize Access',
                        'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
                }

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
