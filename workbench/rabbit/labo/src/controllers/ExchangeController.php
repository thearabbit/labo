<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\ExchangeValidator;

class ExchangeController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['datatable'] = \Datatable::table()
            ->addColumn('Exchange Date', 'USD', 'KHR', 'Description', 'Action')
            ->setUrl(route('labo.api.exchange'))
            ->render();

        return \View::make('labo::exchange.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('labo::exchange.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = ExchangeValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = new ExchangeModel();
        $this->_saveData($data, $inputs);

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
        $data['data'] = ExchangeModel::find($id);

        return \View::make('labo::exchange.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = ExchangeValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs form validator
        $inputs = $validator->inputs();

        $data = ExchangeModel::find($id);
        $this->_saveData($data, $inputs);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.exchange.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = ExchangeModel::find($id);
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
        $data = ExchangeModel::orderBy('exchange_date', 'desc')
            ->get();

        return \Datatable::collection($data)
            ->showColumns('exchange_date')
            ->addColumn(
                'usd',
                function ($model) {
                    return number_format($model->usd, 2);
                }
            )
            ->addColumn(
                'khr',
                function ($model) {
                    return number_format($model->khr, 2);
                }
            )
            ->showColumns('des')
            ->addColumn(
                'action',
                function ($model) {
                    return \Action::make()
                        ->edit(
                            \URL::route('labo.exchange.edit', $model->id),
                            $this->_actionEditDelete($model->id)
                        )
                        ->delete(
                            \URL::route('labo.exchange.destroy', $model->id),
                            $model->id,
                            $this->_actionEditDelete($model->id)
                        )
                        ->get();
                }
            )
            ->searchColumns('exchange_date')
            ->orderColumns('exchange_date', 'usd', 'khr')
            ->make();
    }

    /**
     * Action on editing, deleting (invoice, payment)
     *
     * @param $id
     * @return bool
     */
    private function _actionEditDelete($id)
    {
        $invoice = InvoiceModel::where('exchange_id', '=', $id)->first();
        $payment = PaymentModel::where('exchange_id', '=', $id)->first();

        return (isset($invoice) or isset($payment)) ? false : true;
    }

    /**
     * Save data
     *
     * @param $data
     * @param $inputs
     */
    private function _saveData($data, $inputs)
    {
        $data->exchange_date = $inputs['exchange_date'];
        $data->usd = $inputs['usd'];
        $data->khr = $inputs['khr'];
        $data->des = $inputs['des'];
        $data->save();
    }
}