<?php
namespace Rabbit\Cpanel\Libraries;


class IDGenerator
{
    public function  make($table, $field, $prefix, $suffixLength)
    {

        $id = '';
        $format = '%0' . $suffixLength . 'd';

        $findResult = \DB::table($table)
            ->where($field, 'like', $prefix . '%')
            ->orderBy($field, 'DESC')
            ->first();

        if (is_null($findResult)) {
            $id = $prefix . sprintf($format, 1);
        } else {
            $tmpId = $findResult->$field;
            $tmpIdSuffix = intval(substr($tmpId, strlen($prefix), $suffixLength));
            $tmpIdSuffix++;
            $id = $prefix . sprintf($format, $tmpIdSuffix);
        }

        return $id;
    }
}