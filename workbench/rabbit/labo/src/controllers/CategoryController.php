<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\CategoryValidator;

class CategoryController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['datatable'] = \Datatable::table()
            ->addColumn('Category #', 'Kh Name', 'En Name', 'Description', 'Action')
            ->setUrl(route('labo.api.category'))
            ->render();

        return \View::make('labo::category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('labo::category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = CategoryValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        $data = new CategoryModel();
        $this->_saveData($data);

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
        $data['data'] = CategoryModel::find($id);

        return \View::make('labo::category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = CategoryValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        $data = CategoryModel::find($id);
        $this->_saveData($data);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = CategoryModel::find($id);
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
        $data = CategoryModel::all();

        return \Datatable::collection($data)
            ->showColumns('id', 'kh_name', 'en_name', 'des')
            ->addColumn(
                'action',
                function ($model) {
                    return \Action::make()
                        ->edit(\URL::route('labo.category.edit', $model->id))
                        ->delete(
                            \URL::route('labo.category.destroy', $model->id),
                            $model->id,
                            $this->_actionDelete($model->id)
                        )
                        ->get();
                }
            )
            ->searchColumns('id', 'kh_name', 'en_name')
            ->orderColumns('id', 'kh_name', 'en_name')
            ->make();
    }

    /**
     * Action on deleting (product)
     *
     * @param $id
     * @return bool
     */
    private function _actionDelete($id)
    {
        $data = ProductModel::where('category_id', '=', $id)->first();

        return isset($data) ? false : true;
    }

    /**
     * Save data
     *
     * @param $data
     */
    private function _saveData($data)
    {
        $data->kh_name = \Input::get('kh_name');
        $data->en_name = \Input::get('en_name');
        $data->des = \Input::get('des');
        $data->save();
    }
}