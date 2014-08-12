<?php
namespace Rabbit\Cpanel\Libraries;


class PageProperty
{
    private $routeName;
    private $header = array();
    // Header for AdminLTE
    private $tmpHeader = '<h1>
                            :icon
                            :title
                            :sub_title
                        </h1>';

    private $toolbar = array();
    private $tmpToolbar = '<a href=":url" class="btn btn-:class" role="button">:icon:title</a>&nbsp;';

    /**
     * @param $routeName
     * @return $this
     */
    public function make($routeName)
    {
        $this->routeName = $routeName;
        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function  header($items = array())
    {
        $title = $items['title'];
        $subTitle = (isset($items['sub_title']) ? '<small>' . $items['sub_title'] . '</small>' : '');
        $icon = (isset($items['icon']) ? '<i class="fa fa-' . $items['icon'] . '"></i> ' : '');

        $this->header[$this->routeName] = str_replace(
            array(':icon', ':title', ':sub_title'),
            array($icon, $title, $subTitle),
            $this->tmpHeader
        );

        return $this;
    }

    /**
     * @param null $routeName
     * @return mixed
     */
    public function getHeader($routeName = null)
    {
        if (is_null($routeName) or empty($routeName)) {
            $routeName = \Route::current()->getName();
        }

        $header = (isset($this->header[$routeName]) ? $this->header[$routeName] : 'No Header');
        return $header;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function  toolbar($items = array())
    {
        $toolbar = '';
        $classDefault = 'primary';
        foreach ($items as $value) {
            $title = $value['title'];
            $url = $value['url'];
            $icon = (isset($value['icon']) ? '<i class="fa fa-' . $value['icon'] . '"></i> ' : '');
            $class = (isset($value['class']) ? $value['class'] : $classDefault);

            $toolbar .= str_replace(
                array(':title', ':url', ':icon', ':class'),
                array($title, $url, $icon, $class),
                $this->tmpToolbar
            );
        }

        $this->toolbar[$this->routeName] = '<p>' . $toolbar . '</p>';

        return $this;
    }

    /**
     * @param null $routeName
     * @return mixed
     */
    public function getToolbar($routeName = null)
    {
        if (is_null($routeName) or empty($routeName)) {
            $routeName = \Route::current()->getName();
        }
        $toolbar = (isset($this->toolbar[$routeName]) ? $this->toolbar[$routeName] : '');
        return $toolbar;
    }

}