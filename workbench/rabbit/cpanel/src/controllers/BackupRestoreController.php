<?php
namespace Rabbit\Cpanel;


class BackupRestoreController extends BaseController
{

    /**
     * Show backup form
     *
     * @return \Illuminate\View\View
     */
    public function createBackup()
    {
        $name = 'LaboBackup';
        return \View::make('cpanel::backup_restore.backup', compact('name'));
    }

    /**
     * Post backup
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function storeBackup()
    {
        $rules = array(
            'name' => 'required|alpha'
        );
        $validator = \Validator::make(\Input::all(), $rules);

        if ($validator->fails()) {
            \Notification::error(\Lang::get('cpanel::msg.error'));
            return \Redirect::back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        $path = storage_path('dumps/');
        $fileName = \Input::get('name') . '-' . date('YmdHis') . '.sql';

        \Artisan::call(
            'db:backup',
            array(
                '--local-path' => $path,
                '--filename' => $fileName,
                '--gzip' => '',
                '--cleanup' => ''
            )
        );

        // Delete source backup after backup
//        $this->_deleteFile($path, $fileName);

        return \Response::download($path . $fileName);
    }

    /**
     * Show restore form
     *
     * @return \Illuminate\View\View
     */
    public function createRestore()
    {
        return \View::make('cpanel::backup_restore.restore');
    }

    /**
     * Post restore form
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRestore()
    {
        $rules = array(
            'restore' => 'required'
        );
        $validator = \Validator::make(\Input::all(), $rules);

        if ($validator->fails()) {
            \Notification::error(\Lang::get('cpanel::msg.error'));
            return \Redirect::back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        // Move restore file
        $path = storage_path('dumps/');
        $file = \Input::file('restore');
        $fileOriginalName = explode('-', $file->getClientOriginalName());
        $fileName = 'LaboRestore-' . $fileOriginalName[1];

        $file->move($path, $fileName);

        // Get file content
        $contentFile = \File::get($path . $fileName);

        // Execute sql dump
        \DB::unprepared($contentFile);

        // Delete source backup after restore
//        $this->_deleteFile($path, $fileName);

        \Notification::success(\Lang::get('cpanel::msg.success'));
        return \Redirect::back();
    }

    /**
     * Delete file after backup and restore
     *
     * @param $path
     * @param $fileName
     */
    private function _deleteFile($path, $fileName)
    {
        \App::finish(
            function ($request, $response) use ($path, $fileName) {
                \File::delete($path . $fileName);
            }
        );
    }

}
