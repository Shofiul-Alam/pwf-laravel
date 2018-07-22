<?php
/**
 * Created: md.shofiulalam
 * Date: 25/4/18
 * Time: 1:21 PM
 */
namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class InductionScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $value = true;
        $builder->where('isInduction', $value);
    }
}