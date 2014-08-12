<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\StaffValidator;

class StaffController extends BaseController
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
                'Staff #',
                'Kh Name',
                'En Name',
                'Sex',
                'Date Of Birth',
                'Status',
                'Position',
                'Telephone',
                'Action'
            )
            ->setUrl(route('labo.api.staff'))
            ->render();

        return \View::make('labo::staff.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('labo::staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = StaffValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        $data = new StaffModel();
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
        $data['data'] = StaffModel::find($id);

        return \View::make('labo::staff.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = StaffValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        $data = StaffModel::find($id);
        $this->_saveData($data);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.staff.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = StaffModel::find($id);
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
        $data = StaffModel::orderBy('id')
            ->get();

        return \Datatable::collection($data)
            ->showColumns('id', 'kh_name', 'en_name', 'sex', 'dob', 'status', 'position', 'telephone')
            ->addColumn(
                'action',
                function ($model) {
                    return \Action::make()
                        ->edit(
                            \URL::route('labo.staff.edit', $model->id),
                            $this->_actionEditDelete($model->id)
                        )
                        ->delete(
                            \URL::route('labo.staff.destroy', $model->id),
                            $model->id,
                            $this->_actionEditDelete($model->id)
                        )
                        ->get();
                }
            )
            ->searchColumns('id', 'kh_name', 'en_name', 'sex', 'dob', 'status', 'position')
            ->orderColumns('id', 'kh_name', 'en_name', 'sex', 'dob', 'status', 'position')
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
        $invoice = InvoiceModel::where('staff_id', '=', $id)->first();
        $payment = PaymentModel::where('staff_id', '=', $id)->first();

        return (isset($invoice) or isset($payment)) ? false : true;
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
        $data->sex = \Input::get('sex');
        $data->dob = \Input::get('dob');
        $data->status = \Input::get('status');
        $data->position = \Input::get('position');
        $data->address = \Input::get('address');
        $data->telephone = \Input::get('telephone');
        $data->email = \Input::get('email');
        $data->save();
    }
}