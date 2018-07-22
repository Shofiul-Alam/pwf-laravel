<?php

namespace App\Http\Controllers\Field;

use App\Http\Controllers\ApiController;
use App\Models\Field;
use App\Models\Form;
use App\Models\ValueArr;
use App\Transformers\FieldTransformer;
use App\Transformers\FormTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FieldController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy', 'addFields', 'updateFields']);

        $this->middleware('transform.input:'. FormTransformer::class)->only(['store', 'update']);
        $this->middleware('transform.input:'. FieldTransformer::class)->only(['store', 'update']);
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
        $rules = [
            'name'=> 'required',
            'isInduction' => 'required',
        ];

        $this->validate($request, $rules);

        $user = Auth::user();

        $authenticatedClientId = $user->client->id;

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

    public function addFields(Request $request) {



        $user = Auth::user();

        if($user->isAdmin()) {

            $rules = [
                'form_id'=> 'required',
            ];

            $this->validate($request, $rules);

            $data = $request->all();



            if(count($data['data']) > 0) {
                foreach ($data['data'] as $field) {
                    $field['form_id'] = $data['form_id'];
                    $createdField = Field::create($field);
                    if(isset($field['values']) && count($field['values']) > 0) {
                        foreach ($field['values'] as $value) {
                            $newValue = new ValueArr($value);
                            $createdField->valueArr()->save($newValue);
                        }
                    }
                }
            }
           else {
                return $this->errorResponse('Unprocessable Entity', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $form = Form::findOrFail($field['form_id']);

            return $this->showOne($form);


        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }

    }



    public function updateFields(Request $request) {



        $user = Auth::user();

        if($user->isAdmin()) {

            $rules = [
                'form_id'=> 'required',
            ];


            $data = $request->all();
            $data['form_id'] = $data['data']['identifier'];


            if(count($data['data']) > 0) {
                foreach ($data['data']['fields'] as $field) {
                    $field['form_id'] = $data['form_id'];

                    $updateField = Field::findOrFail($field['id']);
                    $updateField->fill($field);

                    if(!$updateField->isClean()) {
                        $updateField->save();
                    }

                    if(isset($field['value_arr']) && count($field['value_arr']) > 0) {
                        foreach ($field['value_arr'] as $value) {
                            $newValue = ValueArr::findOrFail($value['id']);
                            $newValue->fill($value);

                            if(!$newValue->isClean()) {
                                $newValue->save();
                            }
                        }
                    }
                }
            }
            else {
                return $this->errorResponse('Unprocessable Entity', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $form = Form::findOrFail($data['form_id']);

            return $this->showOne($form);


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
