<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\ApiController;
use App\Models\Order;
use App\Models\Position;
use App\Models\Task;
use App\Transformers\TaskTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. TaskTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return $this->showAll($tasks);
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
            'number_of_employee' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'order_id' => 'required',
            'position_id' => 'required',
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
                $task = Task::create($data);
                return $this->showOne($task, Response::HTTP_CREATED);
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
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {

        return $this->showOne($task);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $user = Auth::user();

        $authenticatedClientId = false;

        if($user->client) {
            $authenticatedClientId = $user->client->id;
        }
        $client = $task->order->project->client;


        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $task->fill($request->all());

            if($task->isClean()) {

                return $this->changeDataToUpdate();
            }
            $task->save();
            return $this->showOne($task);
        } else {
            return $this->unauthorizedAccess();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return $this->showOne($task);
    }
}
