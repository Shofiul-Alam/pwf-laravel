<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use App\Http\Controllers\ApiController;
use App\Transformers\ClientTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ClientController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. ClientTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return $this->showAll($clients);
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
            'user_id'=> 'unique:clients,user_id',
            'company_name' => 'required'
        ];
        $this->validate($request, $rules);

        $user = Auth::user();

        $data = $request->all();
        if(isset($data['user_id']) && $user->id == $data['user_id'] || isset($data['user_id']) && $user->isAdmin()) {
            $client = Client::create($data);
        } else {


            $data['user_id'] = $user->id;
            $client = Client::create($data);
        }


        return $this->showOne($client, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $this->showOne($client);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $user = Auth::user();

        $authenticatedClientId = $user->client->id;

        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $client->fill($request->all());

            if($client->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $client->save();
            return $this->showOne($client);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $this->showOne($client);
    }
}
