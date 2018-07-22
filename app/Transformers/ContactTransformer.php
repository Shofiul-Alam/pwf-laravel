<?php

namespace App\Transformers;




use App\Models\Contact;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Contact $contact)
    {
        return [
            'identifier' => (int) $contact->id,
            'name' => (string) $contact->name,
            'mobile' => (string) $contact->mobile,
            'createdOn' => (string) $contact->created_at,
            'updatedOn' => (string) $contact->updated_at,
            'deletedOn' => (string) $contact->deleted_at
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'mobile' => 'mobile',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at'

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier', 
            'name' => 'name',
            'mobile' => 'mobile',
            'created_at' => 'createdOn', 
            'updated_at' => 'updatedOn', 
            'deleted_at' => 'deletedOn', 
        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
