<?php
namespace Rabbit\Labo\Validators;


use Rabbit\Labo\InvoiceModel;

class FeeValidator extends \ValidatorAssistant
{
    protected function before()
    {
        // Get invoice date
        $invoiceId = \Input::get('invoice_id');
        $invoice = InvoiceModel::find($invoiceId);
        $invoiceDate = date('Y-m-d');
        if (isset($invoice)) {
            $invoiceDate = $invoice->invoice_date;
        }

        $rules = array(
            'fee_date' => 'required|invoice_date:' . $invoiceDate,
            'agent_id' => 'required',
            'invoice_id' => 'required',
            'overdue_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric|min:1',
            'balance' => 'required|numeric',
            'staff_id' => 'required',
            'exchange_id' => 'required',
        );
        $messages = array(
            'invoice_date' => 'The :attribute must be a date after or equal invoice date (' . $invoiceDate . ').',
        );

        $this->inputs['overdue_amount'] = str_replace(',', '', \Input::get('overdue_amount'));
        $this->inputs['paid_amount'] = str_replace(',', '', \Input::get('paid_amount'));
        $this->inputs['balance'] = str_replace(',', '', \Input::get('balance'));

        $this->inputs['status'] = 'Closing';
        if ($this->inputs['balance'] > 0) {
            $this->inputs['status'] = 'Partial';
        }

        $this->rules = $rules;
        $this->messages = $messages;
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rule
    |--------------------------------------------------------------------------
    */
    protected function customInvoiceDate($attribute, $value, $parameters)
    {
        if ($value < $parameters[0]) {
            return false;
        }

        return true;
    }
}