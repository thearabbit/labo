<?php
/**
 * Created by PhpStorm.
 * User: Theara
 * Date: 6/29/14
 * Time: 12:48 PM
 */

namespace Rabbit\Cpanel\Libraries;


class CpanelWidget
{
    /**
     * Current date
     *
     * @return string
     */
    public function currentDate()
    {
        $color = '#367fa9';
        $date = \Carbon::now();
        if ($date->dayOfWeek == 0 or $date->dayOfWeek == 6) {
            $color = '#d43f3a';
        }

        $tmp = '<span style="text-align: center; font-weight: bold; color: '
            . $color
            . '">'
            . $date->format('D jS \\of M Y')
            . '</span>';

//        $tmp = '<input type="text" class="form-control" style="text-align: center; font-weight: bold; color: '
//            . $color
//            . '" readonly="true" value="'
//            . $date->format('D jS \\of M Y')
//            . '">';

        return $tmp;
    }
} 