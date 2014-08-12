<?php
namespace Rabbit\Cpanel;


use Rabbit\Cpanel\Validators\CompanyValidator;

class CompanyController extends BaseController
{

    /**
     * Display a listing of the resource.
     * GET /staffs
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /staffs/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /staffs
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /staffs/{id}
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
     * GET /staffs/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $data['data'] = CompanyModel::find($id);

        return \View::make('cpanel::company.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * PUT /staffs/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $validator = CompanyValidator::make();

        if ($validator->fails()) {
            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $data = CompanyModel::find($id);
        $data->kh_name = \Input::get('kh_name');
        $data->kh_short_name = \Input::get('kh_short_name');
        $data->en_name = \Input::get('en_name');
        $data->en_short_name = \Input::get('en_short_name');
        $data->kh_address = \Input::get('kh_address');
        $data->en_address = \Input::get('en_address');
        $data->telephone = \Input::get('telephone');
        $data->email = \Input::get('email');
        $data->website = \Input::get('website');
        $data->logo = \Input::get('logo');
        $data->save();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back()
            ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /staffs/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}