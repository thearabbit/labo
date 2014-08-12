<?php
namespace Rabbit\Labo;

use Illuminate\Support\Facades\DB;
use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\FeeValidator;
use Rabbit\Labo\Validators\PaymentValidator;

class FeeController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['datatable'] = \Datatable::table()
            ->addColumn(
                'Fee #',
                'Fee Date',
                'Invoice #',
                'Invoice Date',
                'Overdue',
                'Paid',
                'Balance',
                'Agent',
                'Blocked',
                'Action'
            )
            ->setUrl(route('labo.api.fee'))
            ->render();

        return \View::make('labo::fee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('labo::fee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = FeeValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = new FeeModel();
        $data->fee_date = $inputs['fee_date'];
        $data->invoice_id = $inputs['invoice_id'];
        $data->overdue_amount = $inputs['overdue_amount'];
        $data->paid_amount = $inputs['paid_amount'];
        $data->balance = $inputs['balance'];
        $data->status = $inputs['status'];
        $data->staff_id = $inputs['staff_id'];
        $data->exchange_id = $inputs['exchange_id'];
        $data->blocked = 'No';

        $data->save();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = FeeModel::find($id);

        // Get agent
        $invoice = VInvoiceModel::find($data->invoice_id);
        $agentList = array($invoice->agent_id => $invoice->a_kh_name . ' ( ' . $invoice->a_en_name . ' )');
        $invoiceList = array(
            $invoice->id => $invoice->id
                . ' | ' . $invoice->invoice_date
                . ' | Fee Amount: ' . number_format($invoice->fee_amount, 2)
                . ' | Fee Per: ' . number_format($invoice->fee_per, 2)
                . ' | Fee Total: ' . number_format(($invoice->fee_amount + $invoice->fee_per), 2)
        );

        $data['data'] = $data;
        $data['agent_list'] = $agentList;
        $data['invoice_list'] = $invoiceList;

        return \View::make('labo::fee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = FeeValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = FeeModel::find($id);
        $data->fee_date = $inputs['fee_date'];
        $data->staff_id = $inputs['staff_id'];
        $data->exchange_id = $inputs['exchange_id'];

        $data->save();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.fee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = FeeModel::find($id);
        $data->delete();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
    }

    /**
     * Get data table
     *
     * @return mixed
     */
    public function getDatatable()
    {
        $data = \DB::table('v_fee')
            ->orderBy('fee_date', 'desc')
            ->orderBy('id', 'desc');

        return \Datatable::query($data)
            ->showColumns(
                'id',
                'fee_date',
                'invoice_id',
                'invoice_date',
                'overdue_amount',
                'paid_amount',
                'balance',
                'a_kh_name'
            )
            ->addColumn(
                'blocked',
                function ($model) {
                    $blocked = $model->blocked;
                    $class = 'success';
                    if ($blocked == 'Yes') {
                        $class = 'danger';
                    }
                    return '<span class="label label-' . $class . '">' . $blocked . '</span>';
                }
            )
            ->addColumn(
                'action',
                function ($model) {
                    // Check block
                    if ($model->blocked == 'Yes') {
                        return '';
                    }
                    return \Action::make()
                        ->edit(\URL::route('labo.fee.edit', $model->id))
                        ->delete(\URL::route('labo.fee.destroy', $model->id), $model->id)
                        ->get();
                }
            )
            ->searchColumns(
                'id',
//                'fee_date',
                'invoice_id',
//                'invoice_date',
                'overdue_amount',
                'paid_amount',
                'balance',
                'a_kh_name'
            )
            ->orderColumns(
                'id',
//                'fee_date',
                'invoice_id',
//                'invoice_date',
                'overdue_amount',
                'paid_amount',
                'balance',
                'a_kh_name'
            )
            ->make();
    }

    /**
     * Staff change
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function agentChange()
    {
        $agentId = \Input::get('agent_id');
        $data = \DB::table('v_invoice')
            ->whereNotIn(
                'id',
                function ($q) {
                    $q->select('invoice_id')
                        ->distinct()
                        ->from('fee')
                        ->where('status', 'Closing');
                }
            )
            ->where('agent_id', $agentId)
            ->where('blocked', 'No')
            ->get();

        // Check data exist
        if (count($data) > 0) {
            $option = '<option value="" disabled="disabled" selected="selected">- Select One -</option>';
            foreach ($data as $val) {
                $option .= '<option value="' . $val->id . '">' . $val->id . ' | ' . $val->invoice_date
                    . ' | Fee Amount: ' . number_format($val->fee_amount, 2)
                    . ' | Fee Per: ' . number_format($val->fee_per, 2)
                    . ' | Fee Total: ' . number_format(($val->fee_amount + $val->fee_per), 2)
                    . '</option>';
            }
        } else {
            $option = '<option value="" disabled="disabled" selected="selected">- No Invoice -</option>';
        }

        //<option value="" disabled="disabled" selected="selected">- Select One -</option>
//            '<option value="M">Male</option>');

        return \Response::json(
            array(
                'option' => $option,
            )
        );
    }

    /**
     * Invoice change
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invoiceChange()
    {
        $invoiceId = \Input::get('invoice_id');
        $getOverdue = FeeModel::where('invoice_id', '=', $invoiceId)
            ->orderBy('fee_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if ($getOverdue) {
            $overdue = $getOverdue->balance;
        } else {
            // Get from invoice (never paid fee)
            $invoice = InvoiceModel::find($invoiceId);
            $overdue = $invoice->fee_amount + $invoice->fee_per;
        }

        return \Response::json(
            array(
                'overdue' => $overdue,
            )
        );
    }
}