<?php
namespace Rabbit\Labo;

use Rabbit\Cpanel\BaseController;
use Rabbit\Labo\Validators\AgentValidator;

class AgentController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['datatable'] = \Datatable::table()
            ->addColumn('Agent #', 'Kh Name', 'En Name', 'Sex', 'Address', 'Telephone', 'Email', 'Action')
            ->setUrl(route('labo.api.agent'))
            ->render();
        return \View::make('labo::agent.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('labo::agent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = AgentValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        $data = new AgentModel();
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
        $data['data'] = AgentModel::find($id);

        return \View::make('labo::agent.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = AgentValidator::make();
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        $data = AgentModel::find($id);
        $this->_saveData($data);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('labo.agent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = AgentModel::find($id);
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

        $data = AgentModel::all();

        return \Datatable::collection($data)
            ->showColumns('id', 'kh_name', 'en_name', 'sex', 'address', 'telephone', 'email')
            ->addColumn(
                'action',
                function ($model) {
                    return \Action::make()
                        ->edit(
                            \URL::route('labo.agent.edit', $model->id),
                            $this->_actionEditDelete($model->id)
                        )
                        ->delete(
                            \URL::route('labo.agent.destroy', $model->id),
                            $model->id,
                            $this->_actionEditDelete($model->id)
                        )
                        ->get();
                }
            )
            ->searchColumns('id', 'kh_name', 'en_name', 'sex', 'address')
            ->orderColumns('id', 'kh_name', 'en_name', 'sex', 'address')
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
        $invoice = InvoiceModel::where('agent_id', '=', $id)->first();

        return isset($invoice) ? false : true;
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
        $data->address = \Input::get('address');
        $data->telephone = \Input::get('telephone');
        $data->email = \Input::get('email');
        $data->save();
    }
}