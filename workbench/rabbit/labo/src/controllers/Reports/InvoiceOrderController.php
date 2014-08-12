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

class InvoiceOrderController extends BaseController
{

    public function create($id = null)
    {
        // Get company info
        $data['company'] = CompanyModel::find(1);

        $invoice = VInvoiceModel::find($id);
        $data['invoice'] = $invoice;

        $exchange = ExchangeModel::find($invoice->exchange_id);
        $totalUsd = $invoice->total * $exchange->usd / $exchange->khr;
        $data['totalUsd'] = $totalUsd;

        $data['products'] = VInvoiceProductModel::where('invoice_id', '=', $id)
            ->orderBy('id')
            ->get();

        return \View::make('labo::report.invoice_order', $data);
    }
}