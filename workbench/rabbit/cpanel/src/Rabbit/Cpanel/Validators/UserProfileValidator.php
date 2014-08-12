<?php
namespace Rabbit\Cpanel\Validators;


class UserProfileValidator extends \ValidatorAssistant
{
    protected function before()
    {
        \Rule::add('full_name')->required();
        \Rule::add('email')->required()->email()
            ->unique('user', 'email', \Auth::id());
        \Rule::add('username')->required()->alphaDash()->digitsBetween(1, 30)
            ->unique('user', 'username', \Auth::id());
        \Rule::add('old_password')->required()
            ->oldPassword()->message('The old password is invalid.');
        \Rule::add('password')->required()->digitsBetween(6, 15)->confirmed()
            ->alphaAndNum()->message('The field must be contain letters and numeric.');
        \Rule::add('password_confirmation')->required()->digitsBetween(6, 15)
            ->alphaAndNum()->message('The field must be contain letters and numeric.');

        $this->rules = \Rule::get();
        $this->messages = \Rule::getMessages();
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rule
    |--------------------------------------------------------------------------
    */
    protected function customAlphaAndNum($attribute, $value, $parameters)
    {
        if (!preg_match('/[0-9]+/', $value)) {
            return false;
        }

        if (!preg_match('/[a-zA-Z]+/', $value)) {
            return false;
        }

        return true;
    }

    protected function customOldPassword($attribute, $value, $parameters)
    {
        if (\Hash::check($value, \Auth::user()->password)) {
            return true;
        }

        return false;
    }
}