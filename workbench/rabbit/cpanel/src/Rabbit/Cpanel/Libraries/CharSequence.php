<?php
/**
 * Created by PhpStorm.
 * User: Theara
 * Date: 6/29/14
 * Time: 12:48 PM
 */

namespace Rabbit\Cpanel\Libraries;


class CharSequence
{
    /**
     * New line
     *
     * @param int $num
     * @return string
     */
    public function newLine($num = 1)
    {
        $char = '';
        for ($i = 1; $i <= $num; $i++) {
            $char .= '<br>';
        }
        return $char;
    }

    /**
     * White space
     *
     * @param int $num
     * @return string
     */
    public function space($num = 1)
    {
        $char = '';
        for ($i = 1; $i <= $num; $i++) {
            $char .= '&nbsp;';
        }
        return $char;
    }
}