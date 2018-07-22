<?php

namespace App\Http\Controllers\Allocation;

use App\Http\Controllers\ApiController;
use App\Models\Employee;
use App\Models\EmployeeAllocation;
use App\Models\Task;
use App\Models\ViewModels\EmployeeTimeline;
use App\Search\EmployeeSearch\Filters\EmployeeFilter;
use App\Transformers\EmployeeAllocationTransformer;
use App\Transformers\EmployeeTimelineTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeTimelineController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy', 'filterEmployeesForAllocation']);

        $this->middleware('transform.input:'. EmployeeTimelineTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        $timeLines = collect([]);

        $startDate = new \DateTime('2018-05-24');
        $endDate = new \DateTime('2018-05-29');

        $range = array('startDate'=>$startDate, 'endDate'=>$endDate);

        foreach ($employees as $employee) {
            $timeLine = new EmployeeTimeline($employee, $range);
            $timeLines->push($timeLine);
        }

//        return response()->json($timeLines, 200);
        return $this->showAll($timeLines);
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
                'sms' => 'required',
                'task_id' => 'required',
            ];

            $this->validate($request, $rules);
            $data = $request->all();

            if(Task::findOrFail($data['task_id'])) {
                $employeeAllocation = EmployeeAllocation::create($data);
                return $this->showOne($employeeAllocation, Response::HTTP_CREATED);
            }else {

                return $this->unProcessableEntity();
            }

        } else {
            return $this->unauthorizedAccess();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employeeAllocation  $employeeAllocation
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeAllocation $employeeAllocation)
    {

        return $this->showOne($employeeAllocation);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employeeAllocation  $employeeAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeAllocation $employeeAllocation)
    {
        $user = Auth::user();

        $authenticatedClientId = false;

        if($user->client) {
            $authenticatedClientId = $user->client->id;
        }
        $client = $employeeAllocation->order->project->client;


        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $employeeAllocation->fill($request->all());

            if($employeeAllocation->isClean()) {

                return $this->changeDataToUpdate();
            }
            $employeeAllocation->save();
            return $this->showOne($employeeAllocation);
        } else {
            return $this->unauthorizedAccess();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employeeAllocation  $employeeAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeAllocation $employeeAllocation)
    {
        $employeeAllocation->delete();

        return $this->showOne($employeeAllocation);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterEmployeesForAllocation(Request $request)
    {
        $user = Auth::user();



        if($user->isAdmin()) {

            $filter = new EmployeeFilter();
            $filter->fill($request->all());

            $employees = $filter->getEmployees();


            return $this->showAll($employees);
        }else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }


    }
}
