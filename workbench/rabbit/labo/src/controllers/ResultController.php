<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\AgentValidator;

class ResultController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Create invoice result
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function create($id) // Invoice id
    {
        $data['invoice'] = VInvoiceModel::find($id);
        $data['products'] = \DB::table('v_invoice_product')
            ->where('invoice_id', $id)
            ->orderBy('id')
            ->get();

        return \View::make('labo::result.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $inputs = \Input::except(array('invoice_id', '_token'));

        foreach ($inputs as $key => $val) {
            $data = new InvoiceResultModel();
            if (is_array($val)) {
                $val = json_encode($val);
            }
            $data->invoice_id = \Input::get('invoice_id');
            $product = explode('_', $key);
            $data->product_id = $product[1];
            $data->arr_result = $val;
            $data->save();
        }

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.invoice.index');
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
        $data['invoice'] = VInvoiceModel::find($id);
        $data['products'] = \DB::table('v_invoice_result')
            ->where('invoice_id', $id)
            ->orderBy('id')
            ->get();

        return \View::make('labo::result.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $inputs = \Input::except(array('invoice_id', '_method', '_token'));

        // Delete before update
        InvoiceResultModel::where('invoice_id', $id)
            ->delete();

        // Update
        foreach ($inputs as $key => $val) {
            $data = new InvoiceResultModel();
            if (is_array($val)) {
                $val = json_encode($val);
            }
            $data->invoice_id = \Input::get('invoice_id');
            $product = explode('_', $key);
            $data->product_id = $product[1];
            $data->arr_result = $val;
            $data->save();
        }

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}