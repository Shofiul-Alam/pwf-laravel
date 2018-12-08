<?php

namespace App\Http\Controllers\Qualification;

use App\Http\Controllers\ApiController;
use App\Models\Qualification;
use App\Transformers\QualificationTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QualificationController extends ApiController
{

    public function __construct()
    {
        parent::setImageRoot();
        $this->middleware('client.credentials')->only(['index', 'show']);

        $this->middleware('auth:api')->only(['store', 'update', 'index', 'show',
                                                            'destroy', 'getQualificationsByEmployee']);

        $this->middleware('transform.input:'. QualificationTransformer::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $orderBy = QualificationTransformer::originalAttribute(
            $request->input('orderBy')
        );
        $sort = $request->input('sort');
        switch ($sort) {
            case 'asc': $qualifications = Qualification::all()->sortBy($orderBy);
                break;
            case 'desc': $qualifications = Qualification::all()->sortByDesc($orderBy);
                break;
            default: $qualifications = $employees = Qualification::all();
                break;

        }


        return $this->showAll($qualifications);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getQualificationsByEmployee(Request $request)
    {

        $user = Auth::user();

        $authenticatedEmployeeId = false;
        $employeeId = $request->input('employee');

        if($user->employee && $authenticatedEmployeeId == $employeeId) {
            $authenticatedEmployeeId = $user->employee->id;
        }

        if($authenticatedEmployeeId || $user->isAdmin()) {
            $orderBy = QualificationTransformer::originalAttribute(
                $request->input('orderBy')
            );
            $sort = $request->input('sort');

            switch ($sort) {
                case 'asc': $qualifications = Qualification::all()->where('employee_id', $employeeId)->sortBy($orderBy);
                break;
                case 'desc': $qualifications = Qualification::all()->where('employee_id', $employeeId)->sortByDesc($orderBy);
                    break;
                default: $qualifications = Qualification::all()->where('employee_id', $employeeId);
                    break;

            }


            return $this->showAll($qualifications);
        } else {
            return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }


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
            'employee_id' => 'required',
            'skill_id' => 'required',
            'image'=>'image|mimes:jpg,png,jpeg|max:10240'
        ];
        $this->validate($request, $rules);

        $data = $request->all();

        $user = Auth::user();

        $authenticatedEmployeeId = false;

        if($user->employee) {
            $authenticatedEmployeeId = $user->employee->id;
        }


        if($authenticatedEmployeeId || $user->isAdmin()) {

            if(isset($request->image)) {
                $data['qualification_image'] = $request->image->store('');
                $data['qualification_image_url'] = $this->imageRoot. '/img/' . $data['qualification_image'];
                $data['qualification_image_type'] = $request->image->getMimeType();
                $data['qualification_image_size'] = number_format($request->image->getSize()/1024/1024, 2) . "MB";
            }

            if(isset($data['employee_id']) && $authenticatedEmployeeId == $data['employee_id'] || isset($data['employee_id']) && $user->isAdmin()) {

                $qualification = Qualification::create($data);
            } else {
                if(isset($request->image)) {
                    $data['qualification_image'] = $request->image->store('');
                }
                $data['employee_id'] = $authenticatedEmployeeId;
                $qualification = Qualification::create($data);
            }


            return $this->showOne($qualification, Response::HTTP_CREATED);
        } else {
            return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function show(Qualification $qualification)
    {

        return $this->showOne($qualification);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qualification $qualification)
    {
        $data = $request->all();

        $user = Auth::user();

        $authenticatedEmployeeId = false;

        if($user->employee) {
            $authenticatedEmployeeId = $user->employee->id;
        }


        if($qualification->employee->id == $authenticatedEmployeeId || $user->isAdmin()) {



            if(isset($request->image)) {
                Storage::delete($qualification->qualification_image);
                $data['qualification_image'] = $request->image->store('');
                $data['qualification_image_url'] = $this->imageRoot. '/img/' . $data['qualification_image'];
                $data['qualification_image_type'] = $request->image->getMimeType();
                $data['qualification_image_size'] = number_format($request->image->getSize()/1024/1024, 2) . "MB";
            }
            $qualification->fill($data);

            if($qualification->isClean()) {

                return response()->json(['error' => 'You need to specify a different value to update',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $qualification->save();
            return $this->showOne($qualification);
        } else {
            return response()->json(['error' => 'Unauthorize Access',
                'code' => Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualification $qualification)
    {
        $qualification->delete();

        return $this->showOne($qualification);
    }
}
