<?php
namespace Rabbit\Labo\Validators;


class InvoiceValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'invoice_date' => 'required',
            'exchange' => 'required',
            'staff_id' => 'required',
            'agent_id' => 'required',
            'customer_id' => 'required',
            'total_khr' => 'required|numeric',
        );

        // Set add-more rule
        foreach (\Input::get('item') as $key => $value) {
            $rules['item.' . $key] = 'required';
            $rules['cost.' . $key] = 'required';
            $rules['qty.' . $key] = 'required|integer';
        }

        $this->inputs['cost'] = str_replace(',', '', \Input::get('cost'));
        $this->inputs['qty'] = str_replace(',', '', \Input::get('qty'));
        $this->inputs['price'] = str_replace(',', '', \Input::get('price'));
        $this->inputs['total_khr'] = str_replace(',', '', \Input::get('total_khr'));
        $this->inputs['status'] = (\Input::get('status') == true) ? 'Closing' : 'Unpaid';

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