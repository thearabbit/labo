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
use Rabbit\Labo\AgentModel;
use Rabbit\Labo\CustomerModel;
use Rabbit\Labo\ExchangeModel;
use Rabbit\Labo\StaffModel;

class InvoiceController extends BaseController
{

    public function create()
    {
        $date = date('Y-m-d') . ' To ' . date('Y-m-d');
        return \View::make('labo::report.invoice', compact('date'));
    }

    public function store()
    {
        $rules = array(
            'report_type' => 'required',
            'staff_id' => 'required',
            'agent_id' => 'required',
            'customer_id' => 'required',
            'blocked' => 'required',
            'exchange_id' => 'required',
            'date_range' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $rules);
        if ($validator->fails()) {

            \Notification::error(\Lang::get('cpanel::msg.error'));
            return \Redirect::back()
                ->withInput()
                ->withErrors($validator->errors());
        }
        // Get inputs
        $input = new \stdClass();
        $input->rptType = \Input::get('report_type');
        $input->staffId = \Input::get('staff_id');
        $input->agentId = \Input::get('agent_id');
        $input->customerId = \Input::get('customer_id');
        $input->blocked = \Input::get('blocked');
        $input->dateRange = \Input::get('date_range');
        $input->dateRangeExplode = explode(' To ', \Input::get('date_range'));
        $input->exchangeId = \Input::get('exchange_id');

        // Generate report with report type
        $rptData = $this->_reportData($input);

        // Check records
        $count = count($rptData);
        if ($count <= 0) {
            \Notification::warning(\Lang::get('cpanel::msg.no_data'));
            return \Redirect::back()
                ->withInput();
        } // End check records

        // Get info for header and filter
        $company = CompanyModel::find(1);
        $filterData = $this->_filterData($input);

        // Start PHPExcel
        $rptName = 'Invoice Report';
        $rptExtension = '.xlsx';
        $rptLoad = \Config::get('labo::path.report') . $rptName . $rptExtension;

        $objReader = new \PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($rptLoad);

        // Check report type
        if ($input->rptType == 'Default') {
            // Remove sheet group by date
            $objPHPExcel->removeSheetByIndex(1);
            // Get sheet
            $objWorkSheet = $objPHPExcel->getSheetByName('Default');

            // Header
            $objWorkSheet->getCell('A1')->setValue($company->en_name);
            $objWorkSheet->getCell('A2')->setValue($rptName . ' [' . $input->rptType . ']');
            $objWorkSheet->getCell('A3')->setValue('Date Range: ' . $input->dateRange);

            // Filter
            $objWorkSheet->getCell('A5')->setValue('Staff: ' . $filterData->staff);
            $objWorkSheet->getCell('A6')->setValue('Agent: ' . $filterData->agent);
            $objWorkSheet->getCell('A7')->setValue('Customer: ' . $filterData->customer);
            $objWorkSheet->getCell('F5')->setValue('Blocked: ' . $filterData->blocked);
            $objWorkSheet->getCell('G6')->setValue($filterData->exchange->usd);
            $objWorkSheet->getCell('H6')->setValue($filterData->exchange->khr);

            // Content
            $startRow = 10;
            $objWorkSheet->insertNewRowBefore(($startRow + 1), $count);
            $objWorkSheet->removeRow($startRow, 2);
            foreach ($rptData as $key => $val) {
                $rowNum = $startRow + $key;
                $totalFee = '=I' . $rowNum . '+J' . $rowNum;
                $objWorkSheet->getCell('A' . $rowNum)->setValue(($key + 1));
                $objWorkSheet->getCell('B' . $rowNum)->setValue($val->id);
                $objWorkSheet->getCell('C' . $rowNum)->setValue($val->invoice_date);
                $objWorkSheet->getCell('D' . $rowNum)->setValue($val->s_kh_name);
                $objWorkSheet->getCell('E' . $rowNum)->setValue($val->a_kh_name);
                $objWorkSheet->getCell('F' . $rowNum)->setValue($val->c_kh_name);
                $objWorkSheet->getCell('G' . $rowNum)->setValue($val->blocked);
                $objWorkSheet->getCell('H' . $rowNum)->setValue($val->total);
                $objWorkSheet->getCell('I' . $rowNum)->setValue($val->fee_amount);
                $objWorkSheet->getCell('J' . $rowNum)->setValue($val->fee_per);
                $objWorkSheet->getCell('K' . $rowNum)->setValue($totalFee);
            }
        } else { // For group by date
            // Remove sheet default
            $objPHPExcel->removeSheetByIndex(0);
            // Get sheet
            $objWorkSheet = $objPHPExcel->getSheetByName('Group By Date');

            // Header
            $objWorkSheet->getCell('A1')->setValue($company->en_name);
            $objWorkSheet->getCell('A2')->setValue($rptName . ' [' . $input->rptType . ']');
            $objWorkSheet->getCell('A3')->setValue('Date Range: ' . $input->dateRange);

            // Filter
            $objWorkSheet->getCell('A5')->setValue('Staff: ' . $filterData->staff);
            $objWorkSheet->getCell('A6')->setValue('Agent: ' . $filterData->agent);
            $objWorkSheet->getCell('A7')->setValue('Customer: ' . $filterData->customer);
            $objWorkSheet->getCell('C5')->setValue('Blocked: ' . $filterData->blocked);
            $objWorkSheet->getCell('E6')->setValue($filterData->exchange->usd);
            $objWorkSheet->getCell('F6')->setValue($filterData->exchange->khr);

            // Content
            $startRow = 10;
            $objWorkSheet->insertNewRowBefore(($startRow + 1), $count);
            $objWorkSheet->removeRow($startRow, 2);
            foreach ($rptData as $key => $val) {
                $rowNum = $startRow + $key;
                $totalFee = '=D' . $rowNum . '+E' . $rowNum;
                $objWorkSheet->getCell('A' . $rowNum)->setValue(($key + 1));
                $objWorkSheet->getCell('B' . $rowNum)->setValue($val->invoice_date);
                $objWorkSheet->getCell('C' . $rowNum)->setValue($val->sum_total);
                $objWorkSheet->getCell('D' . $rowNum)->setValue($val->sum_fee_amount);
                $objWorkSheet->getCell('E' . $rowNum)->setValue($val->sum_fee_per);
                $objWorkSheet->getCell('F' . $rowNum)->setValue($totalFee);
            }
        } // End check report type

        // Export report
        $fileName = $rptName . ' [' . $input->dateRange . ']' . $rptExtension;
        \CpanelExcelWriter::make($objPHPExcel, $fileName);
    }

    private function _reportData($input)
    {
        $data = \DB::table('v_invoice')
            ->whereBetween('invoice_date', $input->dateRangeExplode);

        if ($input->staffId != 'All') {
            $data = $data->where('staff_id', $input->staffId);
        }
        if ($input->agentId != 'All') {
            $data = $data->where('agent_id', $input->agentId);
        }
        if ($input->customerId != 'All') {
            $data = $data->where('customer_id', $input->customerId);
        }
        if ($input->blocked != 'All') {
            $data = $data->where('blocked', $input->blocked);
        }

        // Check type
        if ($input->rptType == 'Default') {
            $data = $data->orderBy('id')
                ->get();
        } else { // For group by date
            $data = $data->select(
                \DB::raw(
                    'invoice_date, sum(total) as sum_total, sum(fee_amount) as sum_fee_amount, sum(fee_per) as sum_fee_per'
                )
            )
                ->groupBy('invoice_date')
                ->orderBy('invoice_date')
                ->get();
        }

        return $data;
    }

    private function _filterData($input)
    {
        $data = new \stdClass();
        $data->staff = ($input->staffId != 'All') ? StaffModel::find($input->staffId)->kh_name : $input->staffId;
        $data->agent = ($input->agentId != 'All') ? AgentModel::find($input->agentId)->kh_name : $input->agentId;
        $data->customer = ($input->customerId != 'All') ? CustomerModel::find(
            $input->customerId
        )->kh_name : $input->customerId;
        $data->blocked = $input->blocked;
        $data->exchange = ExchangeModel::find($input->exchangeId);

        return $data;
    }
}