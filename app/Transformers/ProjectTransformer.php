<?php

namespace App\Transformers;


use App\Models\Client;
use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Project $project)
    {
        return [
            'identifier' => (int) $project->id,
            'name' => (string) $project->name,
            'address' => (string) $project->address,
            'createdOn' => (string) $project->created_at,
            'updatedOn' => (string) $project->updated_at,
            'deletedOn' => (string) $project->deleted_at,
            'client' => Client::findOrFail($project->client_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $project->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'address' => 'address',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'clientIdentifier' => 'client_id',
        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'address' => 'address',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'client_id' => 'clientIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
