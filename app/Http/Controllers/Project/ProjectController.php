<?php

namespace App\Http\Controllers\project;

use App\Http\Controllers\ApiController;
use App\Models\Project;
use App\Transformers\ProjectTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. ProjectTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return $this->showAll($projects);
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
        $authenticatedClientId = false;

        if($user->client) {
            $authenticatedClientId = $user->client->id;
        }

        if($authenticatedClientId || $user->isAdmin()) {
            $rules = [
                'name'=> 'required',
                'address' => 'required'
            ];
            $this->validate($request, $rules);


            $data = $request->all();

            if(isset($data['client_id']) && $authenticatedClientId == $data['client_id'] || isset($data['client_id']) && $user->isAdmin()) {
                $project = Project::create($data);
            } else {
                $data['client_id'] = $authenticatedClientId;
                $project = Project::create($data);
            }


            return $this->showOne($project, Response::HTTP_CREATED);
        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        return $this->showOne($project);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $user = Auth::user();

        $authenticatedClientId = $user->client->id;

        $client = $project->client;


        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $project->fill($request->all());

            if($project->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $project->save();
            return $this->showOne($project);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return $this->showOne($project);
    }
}
