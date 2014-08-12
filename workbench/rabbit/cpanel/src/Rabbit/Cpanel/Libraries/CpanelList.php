<?php
/**
 * Created by PhpStorm.
 * User: Theara
 * Date: 6/29/14
 * Time: 12:48 PM
 */

namespace Rabbit\Cpanel\Libraries;


class CpanelList
{
    private $selectOne = array('' => '- Select One -');

    /**
     * User type
     *
     * @param bool $selectOne
     * @return array
     */
    public function type($selectOne = true)
    {
        if (!$selectOne) {
            $this->selectOne = array();
        }

        if (\Auth::user()->type == 'Super') {
            $dataTmp = array(
                'Admin' => 'Admin',
                'Guest' => 'Guest',
            );
        } else { // For Admin
            $dataTmp = array(
                'Guest' => 'Guest',
            );
        }

        $data = array_merge(
            $this->selectOne,
            $dataTmp
        );

        return $data;
    }

    /**
     * User permission
     *
     * @param bool $selectOne
     * @return array
     */
    public function permission($selectOne = true)
    {
        if (!$selectOne) {
            $this->selectOne = array();
        }

        $data = array_merge(
            $this->selectOne,
            \Config::get('cpanel::permission')
        );

        return $data;
    }

    /**
     * User active
     *
     * @param bool $selectOne
     * @return array
     */
    public function active($selectOne = true)
    {
        if (!$selectOne) {
            $this->selectOne = array();
        }

        $data = array_merge(
            $this->selectOne,
            array(
                'Yes' => 'Yes',
                'No' => 'No',
            )
        );

        return $data;
    }

} 