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
        $transformedInput = [];
        
        foreach ($request->request->all() as $input => $value) {
            $transformedInput[$transformer::originalAttribute($input)] = $value;
        }

        $request->replace($transformedInput);
        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();
            $transformedErrors = [];
            foreach($data->error as $field => $error) {
                print_r($field);
                print_r(get_class_methods($transformer));
                $transformedField = $transformer::transformedAttribute($field);
                var_dump($transformedField);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
                die;
            }

            $data->error = $transformedErrors;

            $response->setData($data);
        }

        return $response;
    }
}
