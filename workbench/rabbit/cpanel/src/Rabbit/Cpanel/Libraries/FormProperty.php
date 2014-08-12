<?php
namespace Rabbit\Cpanel\Libraries;


class FormProperty
{
    /**
     * @param $title
     * @return string
     */
    public function section($title)
    {
        return '<h4 class="form-section">' . $title . '</h4>';
    }

    public function inputLinkAddOn($title, $url, $target = '_blank')
    {
        return '<a href="' . $url . '" class="btn btn-primary btn-smallest" target="' . $target . '" role="button">' . $title . '</a>';
    }
}
