<?php

namespace App\Http\Controllers\Induction;

use App\Http\Controllers\ApiController;
use App\Models\Form;
use App\Models\Induction;
use App\Transformers\InductionTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InductionController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. InductionTransformer::class)->only(['store', 'update']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Induction::all();

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
        $user = Auth::user();

        $authenticatedClientId = $user->client->id;

        if($authenticatedClientId || $user->isAdmin()) {
            $rules = [
                'name'=> 'required',
                'mobile' => 'required'
            ];
            $this->validate($request, $rules);


            $data = $request->all();


            $form = Form::create($data);

            $form->clients()->syncWithoutDetaching([$authenticatedClientId]);

            return $this->showOne($form, Response::HTTP_CREATED);
        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {

        return $this->showOne($form);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $user = Auth::user();

        $authenticatedClientId = $user->client->id;


        $clients = $form->clients;

        $client = $clients->where('id', $authenticatedClientId)->first();


        if($client || $user->isAdmin()) {

            $form->fill($request->all());

            if($form->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $form->save();
            return $this->showOne($form);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();

        return $this->showOne($form);
    }
}
