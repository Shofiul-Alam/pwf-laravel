<?php

namespace App\Transformers;




use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public static function transform(User $user)
    {
        return [
            'identifier' => (int) $user->id,
            'email' => (string) $user->email,
            'isVerified' => (int) $user->is_verified,
            'isAdmin' => ($user->isAdmin() === true),
            'creationDate' => (string)  $user->created_at,
            'lastChange' => (string) $user->updated_at,
            'deletedDate' => isset($user->deleted_at)? (string) $user->deleted_at: null,
        ];
    }
    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'email' => 'email',
            'isVerified' => 'is_verified',
            'isAdmin' => 'admin',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];
        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'email' => 'email',
            'is_verified' => 'isVerified',
            'admin' => 'isAdmin',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
