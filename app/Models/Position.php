<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\PositionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = PositionTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'pay_rate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function employees() {
        return $this->belongsToMany(Employee::class, 'employee_position');
    }
}
