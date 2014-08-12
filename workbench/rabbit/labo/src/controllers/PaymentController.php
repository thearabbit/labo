<?php
namespace Rabbit\Labo;

use Illuminate\Support\Facades\DB;
use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\PaymentValidator;

class PaymentController extends BaseController
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
                'Payment #',
                'Payment Date',
                'Invoice #',
                'Overdue Amount',
                'Paid Amount',
                'Balance',
                'Blocked',
                'Action'
            )
            ->setUrl(route('labo.api.payment'))
            ->render();

        return \View::make('labo::payment.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data['exchange'] = \LaboWidget::currentExchange();

        return \View::make('labo::payment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = PaymentValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = new PaymentModel();
        $data->payment_date = $inputs['payment_date'];
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
        $data['data'] = PaymentModel::find($id);

        return \View::make('labo::payment.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = PaymentValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = PaymentModel::find($id);
        $data->payment_date = $inputs['payment_date'];
        $data->staff_id = $inputs['staff_id'];
        $data->exchange_id = $inputs['exchange_id'];

        $data->save();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.payment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = PaymentModel::find($id);
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
        $data = PaymentModel::orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc');

        return \Datatable::query($data)
            ->showColumns(
                'id',
                'payment_date',
                'invoice_id',
                'overdue_amount',
                'paid_amount',
                'balance'
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
                        ->edit(\URL::route('labo.payment.edit', $model->id))
                        ->delete(\URL::route('labo.payment.destroy', $model->id), $model->id)
                        ->get();
                }
            )
            ->searchColumns(
                'id',
                'invoice_id',
                'payment_date',
                'overdue_amount',
                'paid_amount',
                'balance',
                'staff_id'
            )
            ->orderColumns(
                'id',
                'invoice_id',
                'payment_date',
                'overdue_amount',
                'paid_amount',
                'balance',
                'staff_id'
            )
            ->make();
    }

    /**
     * Invoice change
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invoiceChange()
    {
        $invoice = \Input::get('invoice');
        $getOverdue = PaymentModel::where('invoice_id', '=', $invoice)
            ->orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if ($getOverdue) {
            $overdue = $getOverdue->balance;
        } else {
            $overdue = InvoiceModel::find($invoice)->total;
        }

        return \Response::json(
            array(
                'overdue' => $overdue,
            )
        );
    }
}