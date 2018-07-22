<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\EmployeeAllocationTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAllocation extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = EmployeeAllocationTransformer::class;

    protected $fillable = [
        'id',
        'request_send_partially',
        'request_send_all',
        'sms',
        'cancalAll',
        'acceptAll',
        'acceptPartially',
        'created_at',
        'updated_at',
        'deleted_at',
        'task_id',
    ];

    public function allocatedDates() {
        return $this->hasMany(AllocatedDate::class);
    }

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
