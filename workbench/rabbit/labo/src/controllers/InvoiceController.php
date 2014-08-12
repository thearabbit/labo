<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\InvoiceValidator;

class InvoiceController extends BaseController
{

    /**
     * Display a listing of the resource.
     * GET /invoice
     *
     * @return Response
     */
    public function index()
    {
        $data['datatable'] = \Datatable::table()
            ->addColumn(
                'Invoice #',
                'Invoice Date',
                'Total',
                'Fee Amount',
                'Fee Per',
                'Staff',
                'Agent',
                'Customer',
                'Blocked',
                'Action'
            )
            ->setUrl(route('labo.api.invoice'))
            ->render();
        return \View::make('labo::invoice.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * GET /invoice/create
     *
     * @return Response
     */
    public function create()
    {
        $data['exchange'] = \LaboWidget::currentExchange();

        return \View::make('labo::invoice.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * POST /invoice
     *
     * @return Response
     */
    public function store()
    {
        $validator = InvoiceValidator::make();
        if ($validator->fails()) {
            return \Response::json(
                array(
                    'success' => false,
                    'alert' => \Lang::get('cpanel::msg.error'),
                    'errors' => $validator->errors()->toArray()
                )
            );
        }

        // Get inputs from validator
        $inputs = $validator->inputs();

        // Generate invoice id
        $exDatetime = explode(' ', $inputs['invoice_date']);
        $exDate = explode('-', $exDatetime[0]);
        $idPrefix = substr($exDate[0], 2, 2) . $exDate[1] . '-';
        $id = \IDGenerator::make('invoice', 'id', $idPrefix, 4);

        // Save invoice
        $invoice = new InvoiceModel();
        $invoice->id = $id;
        $invoice->invoice_date = $inputs['invoice_date'];
        $invoice->staff_id = $inputs['staff_id'];
        $invoice->agent_id = $inputs['agent_id'];
        $invoice->customer_id = $inputs['customer_id'];
        $invoice->total = $inputs['total_khr'];
        $invoice->blocked = 'No';
        $invoice->exchange_id = $inputs['exchange'];
        $invoice->save();

        // Save invoice_product
        $totalFeeAmount = 0;
        $totalFeePer = 0;
        foreach (\Input::get('item') as $key => $val) {
            $product = ProductModel::find($val);
            $price = $product->price;
            $feeType = $product->fee_type;
            $fee = $product->fee;

            $feeCal = 0;
            // Calculate fee
            if ($feeType == 'Amount') {
                $feeCal = $fee;
                $totalFeeAmount += $feeCal;
            } elseif ($feeType == 'Percentage') {
                $feeCal = ($price * $fee) / 100;
                $totalFeePer += $feeCal;
            }

            // Check product exist
            $existProduct = InvoiceProductModel::where('invoice_id', '=', $id)
                ->where('product_id', '=', $val)
                ->first();
            if (is_null($existProduct)) {
                $invoiceProduct = new InvoiceProductModel();
                $invoiceProduct->invoice_id = $id;
                $invoiceProduct->product_id = $val;
                $invoiceProduct->quantity = $inputs['qty'][$key];
                $invoiceProduct->price = $price;
                $invoiceProduct->total = $inputs['price'][$key];
                $invoiceProduct->fee_type = $feeType;
                $invoiceProduct->fee = $fee;
                $invoiceProduct->total_fee = $feeCal;
            } else {
                $invoiceProduct = InvoiceProductModel::find($existProduct->id);
                $newQty = $inputs['qty'][$key] + $existProduct->quantity;
                $newPrice = $newQty * $price;
                $newFeeCal = $newQty * $feeCal;

                $invoiceProduct->quantity = $newQty;
                $invoiceProduct->price = $price;
                $invoiceProduct->total = $newPrice;
                $invoiceProduct->fee_type = $feeType;
                $invoiceProduct->fee = $fee;
                $invoiceProduct->total_fee = $newFeeCal;
            }
            $invoiceProduct->save();
        }

        // Update invoice
        $invoiceUpdate = InvoiceModel::find($id);
        $invoiceUpdate->fee_amount = $totalFeeAmount;
        $invoiceUpdate->fee_per = $totalFeePer;
        $invoiceUpdate->save();

        // Create payment (status = Closing)
        if ($inputs['status'] == 'Closing') {
            $payment = new PaymentModel();
            $this->_createPayment($payment, $invoice, $id);
        }

        return \Response::json(
            array(
                'success' => true,
                'alert' => \Lang::get('cpanel::msg.success') . $inputs['status'],
            )
        );
    }

    /**
     * Display the specified resource.
     * GET /invoice/{id}
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
     * GET /invoice/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $data['invoice'] = InvoiceModel::find($id);
        $data['invoice_pro'] = InvoiceProductModel::where('invoice_id', '=', $id)
            ->orderBy('id')
            ->get();
        $data['exchange'] = ExchangeModel::find($data['invoice']->exchange_id);
        $data['total_usd'] = ($data['invoice']->total * $data['exchange']->usd) / $data['exchange']->khr;

        $payment = PaymentModel::where('invoice_id', $id)->first();
        $data['status'] = isset($payment) ? true : false;

        return \View::make('labo::invoice.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * PUT /invoice/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = InvoiceValidator::make();
        if ($validator->fails()) {
            return \Response::json(
                array(
                    'success' => false,
                    'alert' => \Lang::get('cpanel::msg.error'),
                    'errors' => $validator->errors()->toArray()
                )
            );
        }

        // Get inputs from validator
        $inputs = $validator->inputs();

        // Update invoice
        $invoice = InvoiceModel::find($id);
        $invoice->invoice_date = $inputs['invoice_date'];
        $invoice->staff_id = $inputs['staff_id'];
        $invoice->agent_id = $inputs['agent_id'];
        $invoice->customer_id = $inputs['customer_id'];
        $invoice->total = $inputs['total_khr'];
        $invoice->blocked = 'No';
        $invoice->exchange_id = $inputs['exchange'];
        $invoice->save();

        // Update invoice_product (delete all and insert again)
        $delInvoiceProduct = InvoiceProductModel::where('invoice_id', '=', $id);
        $delInvoiceProduct->delete();

        $totalFeeAmount = 0;
        $totalFeePer = 0;
        foreach (\Input::get('item') as $key => $val) {
            $product = ProductModel::find($val);
            $price = $product->price;
            $feeType = $product->fee_type;
            $fee = $product->fee;

            $feeCal = 0;
            // Calculate fee
            if ($feeType == 'Amount') {
                $feeCal = $fee;
                $totalFeeAmount += $feeCal;
            } elseif ($feeType == 'Percentage') {
                $feeCal = ($price * $fee) / 100;
                $totalFeePer += $feeCal;
            }

            // Check product exist
            $existProduct = InvoiceProductModel::where('invoice_id', '=', $id)
                ->where('product_id', '=', $val)
                ->first();
            if (is_null($existProduct)) {
                $invoiceProduct = new InvoiceProductModel();
                $invoiceProduct->invoice_id = $id;
                $invoiceProduct->product_id = $val;
                $invoiceProduct->quantity = $inputs['qty'][$key];
                $invoiceProduct->price = $price;
                $invoiceProduct->total = $inputs['price'][$key];
                $invoiceProduct->fee_type = $feeType;
                $invoiceProduct->fee = $fee;
                $invoiceProduct->total_fee = $feeCal;
            } else {
                $invoiceProduct = InvoiceProductModel::find($existProduct->id);
                $newQty = $inputs['qty'][$key] + $existProduct->quantity;
                $newPrice = $newQty * $price;
                $newFeeCal = $newQty * $feeCal;

                $invoiceProduct->quantity = $newQty;
                $invoiceProduct->price = $price;
                $invoiceProduct->total = $newPrice;
                $invoiceProduct->fee_type = $feeType;
                $invoiceProduct->fee = $fee;
                $invoiceProduct->total_fee = $newFeeCal;
            }
            $invoiceProduct->save();
        }

        // Update invoice for fee amount
        $invoiceUpdate = InvoiceModel::find($id);
        $invoiceUpdate->fee_amount = $totalFeeAmount;
        $invoiceUpdate->fee_per = $totalFeePer;
        $invoiceUpdate->save();

        // Create payment (status = Closing)
        // Check payment exist
        $payment = PaymentModel::where('invoice_id', $id)->first();
        if (isset($payment)) {
            if ($inputs['status'] == 'Closing') {
                // Update
                $this->_createPayment($payment, $invoice, $id);
            } else {
                // Delete
                $payment->delete();
            }
        } else {
            if ($inputs['status'] == 'Closing') {
                // Create new
                $payment = new PaymentModel();
                $this->_createPayment($payment, $invoice, $id);
            }
        }

        \Notification::success(\Lang::get('cpanel::msg.success'));

        return \Response::json(
            array(
                'success' => true,
                'alert' => \Lang::get('cpanel::msg.success'),
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /invoice/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $invoice = InvoiceModel::find($id);
        $invoice->delete();

        // Delete invoice product
        InvoiceProductModel::where('invoice_id', '=', $id)->delete();

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
        $data = VInvoiceModel::orderBy('invoice_date', 'desc')
            ->orderBy('id', 'desc');

        return \Datatable::query($data)
            ->showColumns('id', 'invoice_date', 'total', 'fee_amount', 'fee_per', 's_kh_name', 'a_kh_name', 'c_kh_name')
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
                    // Check has result or not
                    // Check add or edit
                    $result = InvoiceResultModel::where('invoice_id', $model->id)->first();
                    $resultTitle = 'Add New Result';
                    $resultUrl = \URL::route('labo.result.create', $model->id);
                    $resultPrint = false;
                    if (isset($result->id)) {
                        $resultTitle = 'Edit Result';
                        $resultUrl = \URL::route('labo.result.edit', $model->id);
                        $resultPrint = true;
                    }

                    // Check block
                    if ($model->blocked == 'Yes') {
                        return \Action::make()
                            ->header('Print')
                            ->custom(
                                \URL::route('labo.report-invoice_order.create', $model->id),
                                'Invoice',
                                true,
                                '_blank'
                            )
                            ->custom(
                                \URL::route('labo.report-invoice_result.create', $model->id),
                                'Result',
                                $resultPrint,
                                '_blank'
                            )
                            ->get();
                    } else {
                        return \Action::make()
                            ->edit(
                                \URL::route('labo.invoice.edit', $model->id),
                                $this->_actionEditDelete($model->id)
                            )
                            ->delete(
                                \URL::route('labo.invoice.destroy', $model->id),
                                $model->id,
                                $this->_actionEditDelete($model->id)
                            )
                            ->custom(\URL::route('labo.invoice_block.create', $model->id), 'Block')
                            // Add New - Edit Result
                            ->custom($resultUrl, $resultTitle)
                            ->divider()
                            ->header('Print')
                            ->custom(
                                \URL::route('labo.report-invoice_order.create', $model->id),
                                'Invoice',
                                true,
                                '_blank'
                            )
                            ->custom(
                                \URL::route('labo.report-invoice_result.create', $model->id),
                                'Result',
                                $resultPrint,
                                '_blank'
                            )
                            ->get();
                    }
                }
            )
            ->searchColumns('id', 's_kh_name', 'a_kh_name', 'c_kh_name', 'blocked')
            ->orderColumns('id', 's_kh_name', 'a_kh_name', 'c_kh_name', 'blocked')
            ->make();
    }

    /**
     * Action on editing, deleting (invoice status = block, payment, result)
     *
     * @param $id
     * @return bool
     */
    private function _actionEditDelete($id)
    {
        $payment = PaymentModel::where('invoice_id', $id)->first();

        return isset($payment) ? false : true;
    }


    /**
     * Exchange onChange
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function exchangeChange()
    {
        $q = \Input::get('exchange');
        $exchange = ExchangeModel::find($q);

        return \Response::json(
            array(
                'usd' => $exchange->usd,
                'khr' => $exchange->khr,
                'thb' => $exchange->thb,
            )
        );
    }

    /**
     * Item onChange
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemChange()
    {
        $item = \Input::get('item');
        $price = 0;
        if (!empty($item)) {
            $product = ProductModel::find($item);
            $price = $product->price;
            $feeType = $product->fee_type;
            // Calculate fee
            if ($feeType == 'amount') {
                $fee = $product->fee;
            } elseif ($feeType == 'percentage') {
                $fee = ($product->price * $product->fee) / 100;
            }
        }

        return \Response::json(
            array(
                'cost' => $price,
            )
        );
    }

    /**
     * Block invoice
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createBlock($id)
    {
        $data = InvoiceModel::find($id);
        $data->blocked = 'Yes';
        $data->save();

        // Update payment
        PaymentModel::where('invoice_id', $id)
            ->update(array('blocked' => 'Yes'));
        // Update fee
        FeeModel::where('invoice_id', $id)
            ->update(array('blocked' => 'Yes'));

        \Notification::success(\Lang::get('cpanel::msg . success'));
        return \Redirect::back();
    }

    /**
     * Create payment
     *
     * @param $payment
     * @param $data
     * @param $invoice_id
     */
    private function _createPayment($payment, $data, $invoice_id)
    {
        $payment->payment_date = $data->invoice_date;
        $payment->invoice_id = $invoice_id;
        $payment->overdue_amount = $data->total;
        $payment->paid_amount = $data->total;
        $payment->balance = 0;
        $payment->status = 'Closing';
        $payment->staff_id = $data->staff_id;
        $payment->exchange_id = $data->exchange_id;

        $payment->save();
    }
}