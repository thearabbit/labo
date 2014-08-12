<?php
namespace Rabbit\Cpanel\Libraries;


class Action
{
    private $actionItem = array();

    /**
     * @return Action
     */
    public function make()
    {
        return new self;
    }

    /**
     * @param $url
     * @param bool $enable
     * @return $this
     */
    public function edit($url, $enable = true, $target = '_self')
    {

        if ($enable) {
            $this->actionItem[] = '<li><a href="' . $url . '" target="' . $target . '">Edit</a></li>';
        } else {
            $this->actionItem[] = '<li class="dropdown-header">Edit</li>';
        }
        return $this;
    }

    /**
     * @param $url
     * @param string $item
     * @param bool $enable
     * @return $this
     */
    public function delete($url, $item = '', $enable = true, $target = '_self')
    {
        if ($enable) {
            $this->actionItem[] = '<li><a href="' . $url . '" target="' . $target . '" data-method="delete" data-modal-text="delete this item' . (empty($item) ? '' : ' [' . $item . ']') . ' ?">Delete</a></li>';
        } else {
            $this->actionItem[] = '<li class="dropdown-header">Delete</li>';
        }

        return $this;
    }

    /**
     * @param $url
     * @param bool $enable
     * @return $this
     */
    public function show($url, $enable = true, $target = '_self')
    {
        if ($enable) {
            $this->actionItem[] = '<li><a href="' . $url . '" target="' . $target . '">Show</a></li>';
        } else {
            $this->actionItem[] = '<li class="dropdown-header">Show</li>';
        }
        return $this;
    }

    /**
     * @param $url
     * @param $title
     * @param bool $enable
     * @return $this
     */
    public function custom($url, $title, $enable = true, $target = '_self')
    {
        if ($enable) {
            $this->actionItem[] = '<li><a href="' . $url . '" target="' . $target . '">' . $title . '</a></li>';
        } else {
            $this->actionItem[] = '<li class="dropdown-header">' . $title . '</li>';
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function divider()
    {
        $this->actionItem[] = '<li class="divider"></li>';
        return $this;
    }

    /**
     * @param $title
     * @return $this
     */
    public function header($title)
    {
        $this->actionItem[] = '<li class="dropdown-header"><b><u>' . $title . '</u></b></li>';
        return $this;
    }

    /**
     * @return string
     */
    public function get()
    {
        if (count($this->actionItem) == 0) {
            return 'No Action';
        }

        $action = '<div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu pull-right" role="menu">';

        foreach ($this->actionItem as $value) {
            $action .= $value;
        }

        $action .= '</ul>
                </div>';

        return $action;
    }

} 