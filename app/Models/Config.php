<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\ConfigTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends BaseModel
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $transformer = ConfigTransformer::class;

    protected $fillable = [
        'id',
        'category',
        'property',
        'value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];



}
