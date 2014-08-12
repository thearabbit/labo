<?php
namespace Rabbit\Labo\Validators;


class AgentValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'kh_name' => 'required',
            'en_name' => 'required',
            'sex' => 'required',
            'address' => 'required',
            'telephone' => 'required',
        );

        $this->rules = $rules;
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rule
    |--------------------------------------------------------------------------
    */
    protected function customRule($attribute, $value, $parameters)
    {
        //
    }
}