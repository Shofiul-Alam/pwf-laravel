<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Transformers\ValueArrTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValueArr extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = ValueArrTransformer::class;

    protected $fillable = [
        'label',
        'value',
        'field_id',
    ];

    public function field() {
        return $this->belongsTo(Field::class);
    }

}
