<?php
/**
 * Created by PhpStorm.
 * User: Theara-CBIRD
 * Date: 7/21/14
 * Time: 10:17 AM
 */

namespace Rabbit\Labo\Presenters;

use Laracasts\Presenter\Presenter;

class StaffPresenter extends Presenter
{
    public function getDob()
    {
        return \Carbon::createFromFormat('Y-m-d', $this->dob)->format('d-m-Y');
    }

}