<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\EmployeeFormTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeForm extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = EmployeeFormTransformer::class;

    protected $fillable = [
        'id',
        'form_id',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
