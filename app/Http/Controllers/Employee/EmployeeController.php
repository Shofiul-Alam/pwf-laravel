<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use App\Models\Position;
use App\Transformers\EmployeeTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->except(['resend', 'verify']);

        $this->middleware('transform.input:'. EmployeeTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy = EmployeeTransformer::originalAttribute(
            $request->input('orderBy')
        );
        $sort = $request->input('sort');
        switch ($sort) {
            case 'asc': $employees = Employee::all()->sortBy($orderBy);
                break;
            case 'desc': $employees = Employee::all()->sortByDesc($orderBy);
                break;
            default: $employees = $employees = Employee::all();
                break;

        }

        return $this->showAll($employees);

//        return response()->json($employees, 200);
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
            'user_id'=> 'unique:employees,user_id|required',
            'first_name' => 'required',
            'mobile' => 'required',
            'dob' => 'date',
            'image' => 'image',
        ];


        $user = Auth::user();
        $positions = array();



        if(isset($request['position_id'])){
            $positionIds = $request['position_id'];
            foreach ($positionIds as $id) {
                $position = Position::findOrFail($id);
                if($position) {
                    array_push($positions, $position);
                }
            }
        } else {
            $position = Position::findOrFail(2);
            if($position) {
                array_push($positions, $position);
            }
        }
        if(!$request['user_id']) {
            if($user) {
                $request['user_id'] = $user->id;
            }
        }

        $this->validate($request, $rules);

        $data = $request->all();
        if(isset($request->image)) {
            $data['avater_name'] = $request->image->store('');
        }

        $data['isApproved'] = false;

        if(isset($data['user_id']) && $user->id == $data['user_id'] || isset($data['user_id']) && $user->isAdmin()) {
            $employee = Employee::create($data);
        } else {
            $data['user_id'] = $user->id;
            $employee = Employee::create($data);
        }

        if(count($positions) > 0) {
            $employee->positions()->saveMany($positions);
        }


        return $this->showOne($employee, Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return $this->showOne($employee);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $user = Auth::user();



        if(($user->employee && ($employee->id == $user->employee->id)) || $user->isAdmin()) {

            $employee->fill($request->all());


            if($request->hasFile('image')) {
                Storage::delete($employee->avater_name);

                $employee->avater_name = $request->image->store('');
            }

            if($employee->isClean()) {

                    return response()->json(['error' => 'You need to specify a different value to update',
                        'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $employee->save();
            return $this->showOne($employee);
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
    public function destroy(Employee $employee)
    {
        $employee->delete();
        Storage::delete($employee->avater_name);
        return $this->showOne($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {
        $user = Auth::user();
        if($user->isAdmin()) {
            $id = $request->input('id');
            $approval = $request->input('approval');
            $employee = Employee::findOrFail($id);
            $employee->isApproved = $approval;
            $employee->save();
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }

        return $this->showOne($employee);
    }


}
