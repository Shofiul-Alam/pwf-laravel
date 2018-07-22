<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\ApiController;
use App\Models\Form;
use App\Transformers\FormTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FormController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. FormTransformer::class)->only(['store', 'update']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $forms = Form::all();

        return $this->showAll($forms);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        xdebug_break();
        $user = Auth::user();


        if($user->isAdmin()) {
            $rules = [
                'name'=> 'required',
                'isInduction' => 'required',
            ];

            $this->validate($request, $rules);

            $data = $request->all();

            $form = Form::create($data);
            return $this->showOne($form, Response::HTTP_CREATED);

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
