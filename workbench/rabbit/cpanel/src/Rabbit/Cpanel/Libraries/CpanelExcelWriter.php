<?php
/**
 * Created by PhpStorm.
 * User: Theara
 * Date: 8/2/14
 * Time: 8:13 AM
 */

namespace Rabbit\Cpanel\Libraries;


class CpanelExcelWriter
{
    public function make($objPHPExcel, $fileName)
    {
        // redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
//        header('Cache-Control: max-age=0'); // on PHPExcel
        header('Cache-Control: cache, must-revalidate'); // on Laravel Excel
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . \Carbon::now()->format('D, d M Y H:i:s'));
        header('Pragma: public');

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');

        exit;
    }
} 