<?php

namespace App\Http\Controllers\contact;

use App\Http\Controllers\ApiController;
use App\Models\Contact;
use App\Transformers\ContactTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ContactController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. ContactTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();

        return $this->showAll($contacts);
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


            $contact = Contact::create($data);

            $contact->clients()->syncWithoutDetaching([$authenticatedClientId]);

            return $this->showOne($contact, Response::HTTP_CREATED);
        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {

        return $this->showOne($contact);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $user = Auth::user();

        $authenticatedClientId = $user->client->id;


        $clients = $contact->clients;

        $client = $clients->where('id', $authenticatedClientId)->first();


        if($client || $user->isAdmin()) {

            $contact->fill($request->all());

            if($contact->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $contact->save();
            return $this->showOne($contact);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return $this->showOne($contact);
    }
}
