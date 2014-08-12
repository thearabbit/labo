<?php
namespace Rabbit\Cpanel;

use Illuminate\Support\Facades\Auth;
use Rabbit\Cpanel\Validators\UserProfileValidator;
use Rabbit\Cpanel\Validators\UserValidator;

class UserController extends BaseController
{

    /**
     * Display a listing of the resource.
     * GET /staffs
     *
     * @return Response
     */
    public function index()
    {
        $data['datatable'] = \Datatable::table()
            ->addColumn('User #', 'Full Name', 'Email', 'Type', 'Active', 'User Name', 'Owner', 'Action')
            ->setUrl(route('cpanel.api.user'))
            ->render();

        return \View::make('cpanel::user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * GET /staffs/create
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('cpanel::user.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /staffs
     *
     * @return Response
     */
    public function store()
    {
        $validator = UserValidator::make();

        if ($validator->fails()) {
            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $data = new UserModel();
        $this->_saveData($data);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
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
        $data['data'] = UserModel::find($id);

        return \View::make('cpanel::user.edit', $data);
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
        $validator = UserValidator::make();

        if ($validator->fails()) {
            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        $data = UserModel::find($id);
        $this->_saveData($data);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::route('cpanel.user.index');
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
        $data = UserModel::find($id);
        $data->delete();

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
    }

    /**
     * Show user profile
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $data['data'] = UserModel::find(\Auth::id());
        return \View::make('cpanel::user.profile', $data);
    }

    public function updateProfile()
    {
        $validator = UserProfileValidator::make();

        if ($validator->fails()) {
            \Notification::error(\Lang::get('cpanel::msg.error'));

            return \Redirect::back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        $data = UserModel::find(\Auth::id());
        $this->_saveData($data, true);

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
        $user = \Auth::user();
        if ($user->type == 'Super') {
            $data = UserModel::where('type', '!=', $user->type)
//                ->orderBy('id')
                ->get();
        } else { // For Admin
            $data = UserModel::where('type', '!=', 'Super')
                ->where('type', '!=', $user->type)
                ->where('owner_id', '=', $user->id)
//                ->orderBy('id')
                ->get();
        }
        return \Datatable::collection($data)
            ->showColumns('id', 'full_name', 'email', 'type')
            ->showColumns('active', 'username')
            ->addColumn(
                'owner_id',
                function ($model) {
                    return UserModel::find($model->owner_id)->full_name;
                }
            )
            ->addColumn(
                'action',
                function ($model) {
                    return \Action::make()
                        ->edit(\URL::route('cpanel.user.edit', $model->id))
                        ->delete(\URL::route('cpanel.user.destroy', $model->id), $model->id)
                        ->get();
                }
            )
            ->searchColumns('id', 'full_name', 'email', 'type', 'active', 'username')
            ->orderColumns('id', 'full_name', 'email', 'type', 'active', 'username')
            ->make();
    }

    /**
     * Save data
     *
     * @param $data
     */
    private function _saveData($data, $profile = false)
    {
        $data->full_name = \Input::get('full_name');
        $data->email = \Input::get('email');
        $data->username = \Input::get('username');
        $data->password = \Hash::make(\Input::get('password'));
        $data->password_action = \Input::get('password_action');
        if (!$profile) {
            $data->type = \Input::get('type');
            $data->permission = json_encode(\Input::get('permission'));
            $data->active = \Input::get('active');
            $data->owner_id = \Auth::id();
        }
        $data->save();
    }
}