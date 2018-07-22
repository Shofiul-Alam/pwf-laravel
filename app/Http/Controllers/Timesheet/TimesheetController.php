<?php

namespace App\Http\Controllers\timesheet;

use App\Http\Controllers\ApiController;
use App\Models\Order;
use App\Models\Position;
use App\Models\Timesheet;
use App\Transformers\TimesheetTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. TimesheetTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timesheets = Timesheet::all();

        return $this->showAll($timesheets);
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

            'date' => 'required|date',
            'day' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'hours' => 'required',
            'allocated_date_id' => 'required',
            'order_id' => 'required',
            'project_id' => 'required',
            'client_id' => 'required',
            'employee_id' => 'required',
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
        $authenticatedClientId = false;

       if($user->client) {
           $authenticatedClientId = $user->client->id;
       }



        $data = $request->all();


        $requestOrder = Order::findOrFail($data['order_id']);

        $requestClientId = $requestOrder->project->client->id;

//        Validator::make($input, $rules)->passes();

        if($requestClientId && $authenticatedClientId && $authenticatedClientId == $requestClientId || $requestClientId && $user->isAdmin()) {

            if(Position::findOrFail($data['position_id'])) {
                $timesheet = Timesheet::create($data);
                return $this->showOne($timesheet, Response::HTTP_CREATED);
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
     * @param  \App\timesheet  $timesheet
     * @return \Illuminate\Http\Response
     */
    public function show(Timesheet $timesheet)
    {

        return $this->showOne($timesheet);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\timesheet  $timesheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $user = Auth::user();

        $authenticatedClientId = false;

        if($user->client) {
            $authenticatedClientId = $user->client->id;
        }
        $client = $timesheet->order->project->client;


        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $timesheet->fill($request->all());

            if($timesheet->isClean()) {

                return $this->changeDataToUpdate();
            }
            $timesheet->save();
            return $this->showOne($timesheet);
        } else {
            return $this->unauthorizedAccess();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\timesheet  $timesheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();

        return $this->showOne($timesheet);
    }
}
