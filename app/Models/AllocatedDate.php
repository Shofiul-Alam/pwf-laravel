<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\AllocatedDateTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllocatedDate extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = AllocatedDateTransformer::class;

    protected $fillable = [
        'id',
        'date',
        'day',
        'respond',
        'cancel_allocation',
        'accept_allocation',
        'created_at',
        'updated_at',
        'deleted_at',
        'employee_allocation_id',
        'employee_id',
    ];

    public function timesheet() {
        return $this->hasOne(Timesheet::class);
    }
    public function employeeAllocation() {
        return $this->belongsTo(EmployeeAllocation::class);
    }
}
