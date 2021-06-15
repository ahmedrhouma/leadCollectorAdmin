<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Ownership implements Rule
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function passes($attribute, $value)
    {
        $object = is_object($value) ? $value : (new $this->model)->findOrFail($value);

        return $object->user_id === auth()->id();
    }

    public function message()
    {
        return 'This object does not belong to you.';
    }
}
