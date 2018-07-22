<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\OrderTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = OrderTransformer::class;

    protected $fillable = [
        'id',
        'title',
        'start_date',
        'end_date',
        'description',
        'comments',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'project_id',
    ];

    public function setStartDateAttribute($value) {
        $this->start_date = Carbon::parse($value)->format('d/m/Y');
    }
    public function setEndDateAttribute($value) {
        $this->end_date = Carbon::parse($value)->format('d/m/Y');
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function timesheets() {
        return $this->hasMany(Timesheet::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

}
