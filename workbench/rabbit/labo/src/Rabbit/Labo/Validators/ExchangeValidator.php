<?php
namespace Rabbit\Labo\Validators;


class ExchangeValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'exchange_date' => 'required',
            'usd' => 'required|numeric|min:1',
            'khr' => 'required|numeric|min:100',
        );

        $this->inputs['usd'] = str_replace(',', '', \Input::get('usd'));
        $this->inputs['khr'] = str_replace(',', '', \Input::get('khr'));

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