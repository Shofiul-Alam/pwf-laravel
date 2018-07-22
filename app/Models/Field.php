<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\FieldTransformer;

class Field extends BaseModel
{
    public $transformer = FieldTransformer::class;

    protected $fillable = [
        'id',
        'label',
        'type',
        'class_name',
        'default_value',
        'required',
        'description',
        'placeholder',
        'name',
        'access',
        'inline',
        'value',
        'min',
        'max',
        'form_id',
    ];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function induction() {
        return $this->belongsTo(Form::class);
    }

    public function valueArr() {
        return $this->hasMany(ValueArr::class);
    }
}
