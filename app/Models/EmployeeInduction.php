<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\EmployeeInductionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeInduction extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = EmployeeInductionTransformer::class;

    protected $fillable = [
        'id',
        'induction_details',
        'induction_file_name',
        'induction_file_type',
        'induction_file_url',
        'induction_file_size',
        'created_at',
        'updated_at',
        'deleted_at',
        'form_id',
        'employee_id'
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
