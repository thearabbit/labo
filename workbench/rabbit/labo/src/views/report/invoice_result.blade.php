<!DOCTYPE html>
<html>
<head>
    <title></title>

    <style>
        .invoice-rpt {
            font-size: 14px;
            width: 720px;
        }

        .invoice-body {
            font-size: 14px;
            width: 100%;
        }

        .invoice-head {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .invoice-contact {
            text-align: center;
            font-size: 12px;
            /*font-weight: bold;*/
        }

        .invoice-line {
            text-align: center;
            border-bottom: 1px solid #d9d9d9;
        }

        .invoice-content-right {
            text-align: right;
        }

        .invoice-foot {
            text-align: right;
            font-weight: bold
        }

    </style>

</head>
<body>

<table id="invoice_rpt" class="invoice-rpt" align="center">
    <tr>
        <td colspan="2" class="invoice-head"
            style="font-family: Khmer OS Muol Light, Khmer OS Muol"><?php echo $company->kh_name; ?></td>
    </tr>
    <tr>
        <td colspan="2" class="invoice-head"><?php echo $company->en_name; ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2"
            class="invoice-contact"><?php echo 'អាសយដ្ឋាន៖ ' . $company->kh_address; ?></td>
    </tr>
    <tr>
        <td colspan="2"
            class="invoice-contact"><?php echo 'Address: ' . $company->en_address; ?></td>
    </tr>
    <tr>
        <td colspan="2" class="invoice-contact">
            <?php echo 'ទូរស័ព្ទ / Tel: ' . $company->telephone . ', អ៊ីម៉ែល / Email: ' . $company->email; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="invoice-line"></td>
    </tr>
    <tr>
        <td>Invoice #: <?php echo $invoice->id; ?></td>
        <td>Customer: <?php echo $invoice->c_kh_name; ?></td>
    </tr>
    <tr>
        <td>Date: <?php echo $invoice->invoice_date; ?></td>
        <td>Sex: <?php echo $invoice->c_sex; ?></td>
    </tr>
    <tr>
        <td>Cashier: <?php echo $invoice->s_kh_name; ?></td>
        <td>Age: <?php echo $invoice->c_age; ?> Years</td>
    </tr>
    <tr>
        <td colspan="2" class="invoice-line"></td>
    </tr>
    <tr>
        <td colspan="2">

            <table class="table table-condensed invoice-body">
                <?php
                foreach ($categories as $category) {
                    echo '<thead>
                            <tr>
                                <th colspan="2">' . $category->cat_en_name . '</th>
                            </tr>
                            </thead>';

                    // Get product result
                    $products = DB::table('v_invoice_result')
                        ->where('invoice_id', $invoice->id)
                        ->where('p_category', $category->p_category)
                        ->orderBy('id')
                        ->get();
                    echo '<tbody>';

                    foreach ($products as $product) {
                        // Check child is exist
                        if ($product->p_child == 'Yes') {
                            echo '<tr>
                                    <td colspan="2">' . $product->p_en_name . '</td>
                                    </tr>';
                            $children = json_decode($product->arr_result, true);
                            foreach ($children as $key => $val) {
                                $getChild = \Rabbit\Labo\ProductChildModel::find($key);
                                $length = 100;
                                $productName = sprintf("%'.-{$length}s", $getChild->en_name);
                                echo '<tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                    . $productName
                                    . '</td>
                                    <td>' . $val . ' [ ' . $getChild->normal_value . ' ]</td>
                                    </tr>';
                            }

                        } else {
                            $length = 100;
                            $productName = sprintf("%'.-{$length}s", $product->p_en_name);
                            echo '<tr>
                                    <td>' . $productName . '</td>
                                    <td>' . $product->arr_result . ' [ ' . $product->p_normal_value . ' ]</td>
                                    </tr>';
                        }
                    }

                    echo '</tbody>';
                }
                ?>
                <tfoot class="invoice-foot">
                <tr>
                    <td></td>
                    <td><br><br><br><br>Ph. PHOK SOPHY</td>
                </tr>
                </tfoot>
            </table>

        </td>
    </tr>
</table>

</body>
</html>