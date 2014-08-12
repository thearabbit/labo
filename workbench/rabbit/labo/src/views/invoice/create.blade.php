@extends(Config::get('cpanel::layout'))

@section('css')

@include('labo::invoice.css')

@stop

@section('content')

<?php
$formAction = 'create';
$url = URL::route('labo.invoice.store');

echo Former::vertical_open()
    ->id('my_form')
    ->action($url)
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('invoice_id')
    ->readonly();
echo Former::text('invoice_date')
    ->value(date('Y-m-d'))
    ->required()
    ->date_picker();
echo Former::select('exchange')
    ->options(LaboList::exchange(false), $exchange->id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.exchange.create')));
echo Former::hidden('ex_usd')
    ->value($exchange->usd)
    ->id('ex_usd');
echo Former::hidden('ex_khr')
    ->value($exchange->khr)
    ->id('ex_khr');
echo Former::hidden('ex_thb')
    ->value($exchange->thb)
    ->id('ex_thb');

echo '</div>';
echo '<div class="col-md-6">';

echo Former::select('staff_id', 'Staff')
    ->options(LaboList::staff(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.staff.create')));
echo Former::select('agent_id', 'Agent')
    ->options(LaboList::agent(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.agent.create')));
echo Former::select('customer_id', 'Customer')
    ->options(LaboList::customer(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.customer.create')));

echo '</div></div>';

?>
<table class="table" id="items">
    <tr>
        <th width="40%">Item</th>
        <th>Quantity</th>
        <th>Unit Price (KHR)</th>
        <th>Total Price (KHR)</th>
        <th>Action</th>
    </tr>

    <?php
    foreach (range(1, 3) as $index) {
        echo '<tr class="item_row" >';
        echo '<td>';
        echo Former::select('item[' . $index . ']', '')
            ->id('item_' . $index)
            ->options(LaboList::product())
            ->class('select2 item_name');
//            ->required();

        echo '</td>';
        echo '<td>';
        echo Former::text('qty[' . $index . ']', '')
            ->id('qty_' . $index)
            ->value(1)
            ->class('form-control qty')
            ->data_inputmask('integer');
        echo '</td>';
        echo '<td>';
        echo Former::text('cost[' . $index . ']', '')
            ->id('cost_' . $index)
            ->class('form-control cost')
            ->data_inputmask('integer');
        echo '</td>';
        echo '<td>';
        echo Former::text('price[' . $index . ']', '')
            ->id('price_' . $index)
            ->class('form-control price')
            ->data_inputmask('integer')
            ->readonly();
        echo '</td>';
        echo '<td class="pull-right">';
        echo Former::button('-')
            ->class('btn-danger btn delete');
        echo '</td>';
        echo '</tr>';
    }
    ?>
    <tr>
        <td colspan="4">
            <hr>
        </td>
        <td class="pull-right">
            <?php
            echo Former::button('+')
                ->id('add')
                ->class('btn-primary btn');
            ?>
        </td>
    </tr>
</table>

<?php
echo '<div class="row">
        <div class="col-md-6">';

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('total_khr', 'Grand Total')
    ->data_inputmask('integer')
    ->append('KHR')
    ->readonly();
echo Former::text('total_usd', '')
    ->data_inputmask('decimal')
    ->append('USD')
    ->readonly();
echo Former::checkbox('status', '')
    ->text(' Please check me, if paid.')
    ->check();

echo Former::actions()
//    ->warning_button('Print', array('id' => 'print', 'data-loading-text' => 'Loading...'))
    ->primary_submit('Create', array('id' => 'submit', 'data-loading-text' => 'Loading...'))
    ->inverse_reset('Reset');

echo '</div></div>';

// Add more on js
$counter = $index + 1;
$item = Former::select('item[\' + counter + \']', '')
    ->id('item_\' + counter + \'')
    ->options(LaboList::product())
    ->class('item_name')
    ->wrapAndRender();
$cost = Former::text('cost[\' + counter + \']', '')
    ->id('cost_\' + counter + \'')
    ->data_inputmask('integer')
    ->class('form-control cost')
    ->wrapAndRender();
$qty = Former::text('qty[\' + counter + \']', '')
    ->id('qty_\' + counter + \'')
    ->value(1)
    ->class('form-control qty')
    ->data_inputmask('integer')
    ->wrapAndRender();
$price = Former::text('price[\' + counter + \']', '')
    ->id('price_\' + counter + \'')
    ->class('form-control price')
    ->data_inputmask('integer')
    ->readonly()
    ->wrapAndRender();
$remove = Former::button('-')
    ->class('btn-danger btn delete')
    ->wrapAndRender();

echo Former::close();
?>
@stop

@section('js')

@include('labo::invoice.js')

<script>
    $("#print").click(function () {

        // Set invoice content
        var contentBody = '';
        var totalQty = 0;
        $(".item_row").each(function (i) {
            i += 1;
            var item = $(this).find(".item_name").find(":selected").text();
            var qty = $(this).find(".qty").val();
            totalQty += parseInt(qty.replace(",", ""));
            var cost = $(this).find(".cost").val();
            var price = $(this).find(".price").val();
            var row = "<tr><td>" + i + "</td><td>" + item + "</td>" + "<td class='invoice-content-right'>" + qty + "</td>" + "<td class='invoice-content-right'>" + cost + "</td>" + "<td class='invoice-content-right'>" + price + "</td></tr>";
            contentBody += row;
        });
        var content = $('<table class="table table-condensed invoice-body">');
        var contentHead = "<thead><tr><th>No</th><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>";
        var contentFoot = '<tfoot class="invoice-foot">' +
            '<tr><td colspan="3">Grand Total KHR</td><td colspan="2">' + $("#total_khr").val() + '</td></tr>' +
            '<tr><td colspan="3">UDS</td><td colspan="2">' + $("#total_usd").val() + '</td></tr>' +
            '</tfoot>';
        content.append(contentHead);
        content.append(contentBody);
        content.append(contentFoot);
        var contentWrap = content.wrap('<p>').parent().html();

        // Set invoice report
        var invoiceRpt = $('<table id="invoice_rpt" class="invoice-rpt">');
        invoiceRpt.append('<tr><td colspan="2" class="invoice-head">Rabbit IT Team</td></tr>' +
            '<tr><td colspan="2" class="invoice-contact">Battambang Province, Tel: 070 550 880</td></tr>' +
            '<tr><td colspan="2" class="invoice-line"></td></tr>' +
            '<tr><td>Invoice #: ' + $("#invoice_id").val() + '</td><td>Cashier: ' + $("#staff_id option:selected").text() + '</td></tr>' +
            '<tr><td>Date Time: ' + $("#invoice_date").val() + '</td><td>Customer: ' + $("#customer_id option:selected").text() + '</td></tr>');
        invoiceRpt.append('<tr><td colspan="2">' + contentWrap + '</td></tr>');

        $.print(invoiceRpt);
    });
</script>

@stop
<a href="" target="_self"
