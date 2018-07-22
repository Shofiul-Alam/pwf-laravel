<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\EmployeeInductionDataTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeInductionData extends BaseModel
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = EmployeeInductionDataTransformer::class;

    protected $fillable = [
        'id',
        'value',
        'value_arr_id',
        'field_id',
        'form_id',
        'employee_id',
       ];

    public function field() {
        return $this->belongsTo(Field::class);
    }

    public function form() {
        return $this->belongsTo(Form::class);
    }
}
