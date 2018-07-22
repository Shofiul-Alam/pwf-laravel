<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\TaskTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = TaskTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'charge_rate',
        'pay_rate',
        'number_of_employee',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'order_id',
        'position_id',
    ];

    public function setStartDateAttribute($value) {
        $this->start_date = Carbon::parse($value)->format('d/m/Y');
    }
    public function setEndDateAttribute($value) {
        $this->end_date = Carbon::parse($value)->format('d/m/Y');
    }

    public function employeeAllocations() {
        return $this->hasMany(EmployeeAllocation::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }
}
