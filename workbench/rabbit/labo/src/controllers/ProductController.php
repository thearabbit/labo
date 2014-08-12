<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\ProductValidator;

class ProductController extends BaseController
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
                'Product #',
                'En Name',
                'Price',
                'Fee Type',
                'Fee Amount',
                'Child Result',
                'Category',
                'Action'
            )
            ->setUrl(route('labo.api.product'))
            ->render();

        return \View::make('labo::product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('labo::product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = ProductValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = new ProductModel();
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
        $product = ProductModel::find($id);

        // Check fee type
        if ($product->fee_type == 'Amount') {
            $product->fee = round($product->fee);
        }
        $data['data'] = $product;

        return \View::make('labo::product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = ProductValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = ProductModel::find($id);
        $this->_saveData($data, $inputs);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = ProductModel::find($id);
        $data->delete();

        // Delete product child
        ProductChildModel::where('product_id', $id)->delete();

//        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
    }

    /**
     * Get data table
     *
     * @return mixed
     */
    public function getDatatable()
    {
        $data = VProductModel::all();

        return \Datatable::collection($data)
            ->showColumns('id', 'en_name')
            ->addColumn(
                'price',
                function ($model) {
                    return number_format($model->price);
                }
            )
            ->showColumns('fee_type')
            ->addColumn(
                'fee',
                function ($model) {
                    return number_format($model->fee, 2);
                }
            )
            ->showColumns('child', 'cat_en_name')
            ->addColumn(
                'action',
                function ($model) {
                    // Check child
                    $show = false;
                    if ($model->child == 'Yes') {
                        $show = true;
                    }
                    return \Action::make()
                        ->edit(
                            \URL::route('labo.product.edit', $model->id),
                            $this->_actionEditDelete($model->id)
                        )
                        ->delete(
                            \URL::route('labo.product.destroy', $model->id),
                            $model->id,
                            $this->_actionEditDelete($model->id)
                        )
                        ->custom(\URL::route('labo.product_child.index', $model->id), 'Child Result', $show)
                        ->get();
                }
            )
            ->searchColumns('id', 'en_name', 'price', 'fee_type', 'fee', 'child', 'cat_en_name')
            ->orderColumns('id', 'en_name', 'price', 'fee_type', 'fee', 'child', 'cat_en_name')
            ->make();
    }

    /**
     * Action on editing, deleting (invoice_product)
     *
     * @param $id
     * @return bool
     */
    private function _actionEditDelete($id)
    {
        $data = InvoiceProductModel::where('product_id', '=', $id)->first();

        return isset($data) ? false : true;
    }


    /**
     * Save data
     *
     * @param $data
     * @param $inputs
     */
    private function _saveData($data, $inputs)
    {
        $data->category_id = $inputs['category_id'];
        $data->kh_name = $inputs['kh_name'];
        $data->en_name = $inputs['en_name'];
        $data->normal_value = $inputs['normal_value'];
        $data->price = $inputs['price'];
        $data->fee_type = $inputs['fee_type'];
        $data->fee = $inputs['fee'];
        $data->child = $inputs['child'];
        $data->save();
    }
}