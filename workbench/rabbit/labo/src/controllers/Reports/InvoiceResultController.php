<?php
/**
 * Created by PhpStorm.
 * User: Theara-CBIRD
 * Date: 7/31/14
 * Time: 10:35 AM
 */

namespace Rabbit\Labo\Reports;


use Rabbit\Cpanel\BaseController;
use Rabbit\Cpanel\CompanyModel;
use Rabbit\Labo\ExchangeModel;
use Rabbit\Labo\VInvoiceModel;
use Rabbit\Labo\VInvoiceProductModel;

class InvoiceResultController extends BaseController
{

    public function create($id = null)
    {
        // Get company info
        $data['company'] = CompanyModel::find(1);

        $data['invoice'] = VInvoiceModel::find($id);
        $data['categories'] = \DB::table('v_invoice_result')
            ->select('p_category', 'cat_en_name')
            ->distinct('p_category')
            ->where('invoice_id', $id)
            ->orderBy('id')
            ->get();

        return \View::make('labo::report.invoice_result', $data);
    }

}