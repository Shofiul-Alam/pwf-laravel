<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {

        $transformInput = [];

        foreach($request->request->all() as $input=> $value) {
            if(!is_array($value)) {
                $transformInput[$transformer::originalAttribute($input)] = $value;
            } else {
                $className =ucfirst($input).'Transformer';
                $transformer = '\\App\\Transformers\\'.$className;
                foreach( $value as $keyInput=>$v) {
                    $transformInput[$input][$transformer::originalAttribute($keyInput)] = $v;
                }
            }

        }

        $request->replace($transformInput);

        $response = $next($request);

        if(isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErros = [];

            foreach($data->error as $field => $error) {
                $transformedField = $transformer::transformedAttribute($field);

                $transformedErros[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->error = $transformedErros;

            $response->setData($data);
        }

        return $response;
    }
}
