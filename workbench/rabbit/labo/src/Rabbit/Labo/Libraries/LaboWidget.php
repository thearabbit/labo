<?php
/**
 * Created by PhpStorm.
 * User: Theara
 * Date: 6/29/14
 * Time: 12:48 PM
 */

namespace Rabbit\Labo\Libraries;

use Rabbit\Labo\ExchangeModel;

class LaboWidget
{
    public function currentExchange($date = null)
    {
        if (is_null($date) or empty($date)) {
            $date = date('Y-m-d');
        }
        $data = ExchangeModel::where('exchange_date', '<=', $date)
            ->orderBy('exchange_date', 'desc')
            ->first();

        return $data;
    }
}