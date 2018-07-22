<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\FormTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends BaseModel
{
    const INDUCTION = true;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = FormTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'isInduction',
        'induction_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function fields() {
        return $this->hasMany(Field::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }

    public function isInduction() {
        return $this->isInduction == Form::INDUCTION;
    }
}
