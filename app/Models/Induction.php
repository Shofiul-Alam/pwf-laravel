<?php
namespace App\Models;

use App\Scopes\InductionScope;
use App\Transformers\InductionTransformer;

class Induction extends Form
{
    protected $table = 'forms';

    public $transformer = InductionTransformer::class;

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new InductionScope());
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }


}