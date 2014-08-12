<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\ProductChildValidator;
use Rabbit\Labo\Validators\ProductValidator;

class ProductChildController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id, $child_id = null)
    {
        if (is_null($child_id)) {
            $data['form'] = 'create';
        } else {
            $data['form'] = 'update';
            $data['data'] = ProductChildModel::find($child_id);
        }

        $data['datatable'] = \Datatable::table()
            ->addColumn(
                'Child #',
                'Kh Name',
                'En Name',
                'Normal Value',
                'Action'
            )
            ->setUrl(route('labo.api.product_child', $id))
            ->render();

        $product = ProductModel::find($id);
        $data['product'] = $product;
        $data['category'] = CategoryModel::find($product->category_id);

        return \View::make('labo::product_child.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = ProductChildValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = new ProductChildModel();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = ProductChildValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs from validator
        $inputs = $validator->inputs();

        $data = ProductChildModel::find($id);
        $this->_saveData($data, $inputs);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.product_child.index', $data->product_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = ProductChildModel::find($id);
        $data->delete();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
    }

    /**
     * Get data table
     *
     * @param $id
     * @return mixed
     */
    public function getDatatable($id)
    {
//        echo $id; exit;
        $data = ProductChildModel::where('product_id', '=', $id)->get();

        return \Datatable::collection($data)
            ->showColumns('id', 'kh_name', 'en_name', 'normal_value')
            ->addColumn(
                'action',
                function ($model) {
                    return \Action::make()
                        ->edit(\URL::route('labo.product_child.edit', array($model->product_id, $model->id)))
                        ->delete(\URL::route('labo.product_child.destroy', $model->id), $model->id)
                        ->get();
                }
            )
            ->searchColumns('id', 'kh_name', 'en_name', 'normal_value')
            ->orderColumns('id', 'kh_name', 'en_name', 'normal_value')
            ->make();
    }

    /**
     * Save data
     *
     * @param $data
     * @param $inputs
     */
    private function _saveData($data, $inputs)
    {
        $data->product_id = $inputs['product_id'];
        $data->kh_name = $inputs['kh_name'];
        $data->en_name = $inputs['en_name'];
        $data->normal_value = $inputs['normal_value'];
        $data->save();
    }
}