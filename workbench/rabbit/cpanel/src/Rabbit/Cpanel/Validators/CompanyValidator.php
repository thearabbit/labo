<?php
namespace Rabbit\Cpanel\Validators;


class CompanyValidator extends \ValidatorAssistant
{
    protected function before()
    {
        \Rule::add('kh_name')->required();
        \Rule::add('kh_short_name')->required();
        \Rule::add('en_name')->required();
        \Rule::add('en_short_name')->required();
        \Rule::add('kh_address')->required();
        \Rule::add('en_address')->required();
        \Rule::add('telephone')->required();

        $this->rules = \Rule::get();
    }
}