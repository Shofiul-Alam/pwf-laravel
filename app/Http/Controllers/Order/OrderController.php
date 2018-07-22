<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\ApiController;
use App\Models\Order;
use App\Models\Project;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. OrderTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return $this->showAll($orders);
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
            'project_id'=> 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
        $authenticatedClientId = false;

        if($user->client) {
            $authenticatedClientId = $user->client->id;
        }


        $data = $request->all();

        $requestProject = Project::findOrFail($data['project_id']);

        $requestClientId = $requestProject->client->id;

        if($authenticatedClientId == $requestClientId || $user->isAdmin()) {

            if(isset($data['project_id'])) {
                $order = Order::create($data);
                return $this->showOne($order, Response::HTTP_CREATED);
            } else {
                return $this->errorResponse('Unprocessable Entity', Response::HTTP_UNPROCESSABLE_ENTITY);
            }


        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        return $this->showOne($order);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $user = Auth::user();

        $authenticatedClientId = $user->client->id;

        $client = $order->project->client;


        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $order->fill($request->all());

            if($order->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $order->save();
            return $this->showOne($order);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $this->showOne($order);
    }
}
