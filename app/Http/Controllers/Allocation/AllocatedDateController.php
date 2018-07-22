<?php

namespace App\Http\Controllers\Allocation;

use App\Http\Controllers\ApiController;
use App\Models\EmployeeAllocation;
use App\Models\AllocatedDate;
use App\Transformers\AllocatedDateTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AllocatedDateController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show', 'destroy']);

        $this->middleware('transform.input:'. AllocatedDateTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocatedDates = AllocatedDate::all();

        return $this->showAll($allocatedDates);
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
//                'sms' => 'required',
                'date' => 'required|date',
//                'day' => 'required',
                'employee_allocation_id' => 'required',
                'employee_id' => 'required',
            ];

            $this->validate($request, $rules);
            $data = $request->all();

            if(EmployeeAllocation::findOrFail($data['employee_allocation_id'])) {
                $allocatedDate = AllocatedDate::create($data);
                return $this->showOne($allocatedDate, Response::HTTP_CREATED);
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
     * @param  \App\allocatedDate  $allocatedDate
     * @return \Illuminate\Http\Response
     */
    public function show(AllocatedDate $allocatedDate)
    {

        return $this->showOne($allocatedDate);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\allocatedDate  $allocatedDate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AllocatedDate $allocatedDate)
    {
        $user = Auth::user();

        $authenticatedClientId = false;

        if($user->client) {
            $authenticatedClientId = $user->client->id;
        }
        $client = $allocatedDate->order->project->client;


        if($client->id == $authenticatedClientId || $user->isAdmin()) {

            $allocatedDate->fill($request->all());

            if($allocatedDate->isClean()) {

                return $this->changeDataToUpdate();
            }
            $allocatedDate->save();
            return $this->showOne($allocatedDate);
        } else {
            return $this->unauthorizedAccess();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\allocatedDate  $allocatedDate
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllocatedDate $allocatedDate)
    {
        $allocatedDate->delete();

        return $this->showOne($allocatedDate);
    }
}
