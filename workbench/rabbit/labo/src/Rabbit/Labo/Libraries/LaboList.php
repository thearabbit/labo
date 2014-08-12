<?php
/**
 * Created by PhpStorm.
 * User: Theara
 * Date: 6/29/14
 * Time: 12:48 PM
 */

namespace Rabbit\Labo\Libraries;

use Rabbit\Labo\AgentModel;
use Rabbit\Labo\CategoryModel;
use Rabbit\Labo\CustomerModel;
use Rabbit\Labo\ExchangeModel;
use Rabbit\Labo\ProductModel;
use Rabbit\Labo\StaffModel;
use Rabbit\Labo\VInvoiceModel;

class LaboList
{
    private $selectOne = '- Select One -';
    private $optionAll = '- All -';

    /**
     * Sex
     *
     * @param bool $selectOne
     * @return array
     */
    public function sex($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = array(
            'M' => 'Male',
            'F' => 'Female'
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Staff, Agent, Customer Status
     *
     * @param bool $selectOne
     * @return array
     */
    public function status($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = array(
            'Single' => 'Single',
            'Married' => 'Married',
            'Divorced' => 'Divorced'
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Position
     *
     * @param bool $selectOne
     * @return array
     */
    public function position($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = array(
            'Cashier' => 'Cashier',
            'Accountant' => 'Accountant',
            'Admin' => 'Admin',
            'Director' => 'Director',
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Staff list
     *
     * @param bool $selectOne
     * @param bool $optionAll
     * @return array
     */
    public function staff($selectOne = true, $optionAll = false)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        if ($optionAll) {
            $lists['All'] = $this->optionAll;
        }

        $data = StaffModel::all();
        foreach ($data as $row) {
            $lists[$row->id] = $row->kh_name . ' ( ' . $row->en_name . ' ) | ' . $row->position;
        }

        return $lists;
    }

    /**
     * Agent list
     *
     * @param bool $selectOne
     * @param bool $optionAll
     * @return array
     */
    public function agent($selectOne = true, $optionAll = false)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        if ($optionAll) {
            $lists['All'] = $this->optionAll;
        }

        $data = AgentModel::all();
        foreach ($data as $row) {
            $lists[$row->id] = $row->kh_name . ' ( ' . $row->en_name . ' )';
        }

        return $lists;
    }

    /**
     * Customer list
     *
     * @param bool $selectOne
     * @param bool $optionAll
     * @return array
     */
    public function customer($selectOne = true, $optionAll = false)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        if ($optionAll) {
            $lists['All'] = $this->optionAll;
        }

        $data = CustomerModel::all();
        foreach ($data as $row) {
            $lists[$row->id] = $row->kh_name . ' ( ' . $row->en_name . ' ) | ' . $row->sex . ' | ' . $row->age;
        }

        return $lists;
    }

    /**
     * Product
     *
     * @param bool $selectOne
     * @return array
     */
    public function exchange($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = ExchangeModel::orderBy('exchange_date', 'desc')->get();
        foreach ($data as $row) {
            $lists[$row->id] = $row->exchange_date . ' | ' . $row->usd . ' USD | ' . $row->khr . ' KHR';
        }

        return $lists;
    }

    /**
     * Category
     *
     * @param bool $selectOne
     * @return array
     */
    public function category($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = CategoryModel::all();
        foreach ($data as $val) {
            $lists[$val->id] = $val->id . ' | ' . $val->kh_name . ' | ' . $val->en_name;
        }

        return $lists;
    }

    /**
     * Child
     *
     * @param bool $selectOne
     * @return array
     */
    public function child($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = array(
            'Yes' => 'Yes',
            'No' => 'No'
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Fee type
     *
     * @param bool $selectOne
     * @return array
     */
    public function feeType($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $data = array(
            'Percentage' => 'Percentage',
            'Amount' => 'Amount'
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Product
     *
     * @param bool $selectOne
     * @return array
     */
    public function product($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        $cate = CategoryModel::all();
        foreach ($cate as $cateList) {
            $product = ProductModel::where('category_id', '=', $cateList->id)->get();
            $temProduct = array();
            foreach ($product as $productList) {
                $temProduct[$productList->id] = $productList->en_name . ' | ' . $productList->price;
            }
            $lists[$cateList->en_name] = $temProduct;
        }

        return $lists;
    }

    /**
     * Blocked status
     *
     * @param bool $selectOne
     * @param bool $optionAll
     * @return array
     */
    public function blocked($selectOne = true, $optionAll = false)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        if ($optionAll) {
            $lists['All'] = $this->optionAll;
        }

        $data = array(
            'Yes' => 'Yes',
            'No' => 'No',
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Invoice list
     *
     * @param bool $selectOne
     * @param bool $onlyId
     * @return array
     */
    public function invoice($selectOne = true, $onlyId = false)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }

        // Check create or edit form
        if ($onlyId) {
            $data = VInvoiceModel::where('id', $onlyId)
                ->orderBy('invoice_date', 'desc')
                ->get();
        } else {
            $data = VInvoiceModel::whereNotIn(
                'id',
                function ($q) {
                    $q->select('invoice_id')
                        ->distinct()
                        ->from('payment')
                        ->where('status', 'Closing');
                }
            )
                ->where('blocked', 'No')
                ->get();
        }
        foreach ($data as $val) {
            $lists[$val->id] = $val->id . ' | ' . $val->invoice_date . ' | ' . number_format($val->total, 2)
                . ' | Agent: ' . $val->a_kh_name . '( ' . $val->a_en_name . ')';
        }

        return $lists;
    }

    /**
     * Payment status
     *
     * @param bool $selectOne
     * @param bool $optionAll
     * @return array
     */
    public function paymentStatus($selectOne = true, $optionAll = false)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }
        if ($optionAll) {
            $lists['All'] = $this->optionAll;
        }

        $data = array(
            'Closing' => 'Closing',
//            'Partial' => 'Partial',
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

    /**
     * Payment status
     *
     * @param bool $selectOne
     * @return array
     */
    public function reportType($selectOne = true)
    {
        $lists = array();
        if ($selectOne) {
            $lists[''] = $this->selectOne;
        }

        $data = array(
            'Default' => 'Default',
            'Group By Date' => 'Group By Date',
        );
        foreach ($data as $key => $val) {
            $lists[$key] = $val;
        }

        return $lists;
    }

}