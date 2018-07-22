<?php

namespace App\Transformers;


use App\Models\Client;
use App\User;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Client $client)
    {
        return [
            'identifier' => (int) $client->id,
            'company' => (string) $client->company_name,
            'abn' => (string) $client->company_abn_no,
            'phone' => (string) $client->office_phone,
            'mobile' => (string) $client->mobile,
            'contact' => (string) $client->contact_details,
            'acn' => (string) $client->acn_no,
            'tfn' => (string) $client->tfn,
            'creditLimit' => (string) $client->credit_limit,
            'avater' => (string) $client->client_avater_name,
            'avaterUrl' => (string) $client->client_avater_url,
            'avaterType' => (string) $client->client_avater_type,
            'avaterSize' => (string) $client->client_avater_size,
            'createdOn' => (string) $client->created_at,
            'updatedOn' => (string) $client->updated_at,
            'deletedOn' => (string) $client->deleted_at,
            'user' => User::findOrFail($client->user_id),

            'links' =>[
//                [
//                    'rel' => 'access.vehicle',
//                    'href' => route('vehicles.show', $client->vehicle_id),
//                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier' => 'id',
            'company' => 'company_name',
            'abn' => 'company_abn_no',
            'phone' => 'office_phone',
            'mobile' => 'mobile',
            'contact' => 'contact_details',
            'acn' => 'acn_no',
            'tfn' => 'tfn_no',
            'creditLimit' => 'credit_limit',
            'avater' => 'client_avater_name',
            'avaterUrl' => 'client_avater_url',
            'avaterType' => 'client_avater_type',
            'avaterSize' => 'client_avater_size',
            'createdOn' => 'created_at',
            'updatedOn' => 'updated_at',
            'deletedOn' => 'deleted_at',
            'userIdentifier' => 'user_id',


        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id' => 'identifier',
            'company_name' => 'company',
            'company_abn_no' => 'abn',
            'office_phone' => 'phone',
            'mobile' => 'mobile',
            'contact_details' => 'contact',
            'acn_no' => 'acn',
            'tfn_no' => 'tfn',
            'credit_limit' => 'creditLimit',
            'client_avater_name' => 'avater',
            'client_avater_url' => 'avaterUrl',
            'client_avater_type' => 'avaterType',
            'client_avater_size' => 'avaterSize',
            'created_at' => 'createdOn',
            'updated_at' => 'updatedOn',
            'deleted_at' => 'deletedOn',
            'user_id' => 'userIdentifier',

        ];

        return isset($attributes[$index])? $attributes[$index]: null;
    }
}
