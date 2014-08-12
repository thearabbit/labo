<!DOCTYPE html>
<html>
<head>
    <title></title>

    <style>
        .invoice-rpt {
            font-size: 9px;
            width: 260px;
        }

        .invoice-body {
            font-size: 9px;
            width: 100%;
        }

        .invoice-head {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .invoice-contact {
            text-align: center;
            font-size: 8px;
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

        @page {
            size: 80mm 297mm;
            margin: 0mm;
        }

    </style>

</head>
<body>

<table id="invoice_rpt" class="invoice-rpt" align="center">
    <tr>
        <td colspan="2" class="invoice-head"><?php echo $company->kh_name ?></td>
    </tr>
    <tr>
        <td colspan="2"
            class="invoice-contact"><?php echo $company->kh_address . ', ទូរស័ព្ធ៖ ' . $company->telephone; ?></td>
    </tr>
    <tr>
        <td colspan="2" class="invoice-line"></td>
    </tr>
    <tr>
        <td>Invoice #: <?php echo $invoice->id; ?></td>
        <td>Cashier: <?php echo $invoice->s_kh_name; ?></td>
    </tr>
    <tr>
        <td>Date: <?php echo $invoice->invoice_date; ?></td>
        <td>Customer: <?php echo $invoice->c_kh_name; ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="table table-condensed invoice-body">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="4" class="invoice-line"></td>
                </tr>
                <?php
                $i = 1;
                foreach ($products as $product) {
                    echo '<tr>';
                    echo '<td>' . $i . '</td>';
                    echo '<td>' . $product->p_en_name . '</td>';
                    echo '<td class="invoice-content-right">' . number_format($product->price) . '</td>';
                    echo '<td class="invoice-content-right">' . number_format($product->total) . '</td>';
                    echo '</tr>';
                    $i++;
                }
                ?>
                </tbody>
                <tfoot class="invoice-foot">
                <tr>
                    <td colspan="2">Grand Total KHR</td>
                    <td colspan="2"><?php echo number_format($invoice->total, 0); ?></td>
                </tr>
                <tr>
                    <td colspan="2">UDS</td>
                    <td colspan="2"><?php echo number_format($totalUsd, 2); ?></td>
                </tr>
                </tfoot>
            </table>

        </td>
    </tr>
</table>

</body>
</html>