<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\TmpImageTransformer;

class TmpImage extends BaseModel
{

    public $transformer = TmpImageTransformer::class;

    protected $fillable = [
        'id',
        'name',
        'type',
        'mime',
        'size',
        'url',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
