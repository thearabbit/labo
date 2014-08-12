@extends(Config::get('cpanel::layout'))

@section('css')

@include('labo::invoice.css')

@stop

@section('content')

<?php
$formAction = 'edit';
$url = URL::route('labo.invoice.update', $invoice->id);
$redirect = URL::route('labo.invoice.index');

echo Former::vertical_open()
    ->id('my_form')
    ->action($url)
    ->method('put');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('invoice_id')
    ->value($invoice->id)
    ->readonly();

echo Former::text('invoice_date')
    ->value($invoice->invoice_date)
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
    ->options(LaboList::staff(false), $invoice->staff_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.staff.create')));

echo Former::select('agent_id', 'Agent')
    ->options(LaboList::agent(false), $invoice->agent_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.agent.create')));
echo Former::select('customer_id', 'Customer')
    ->options(LaboList::customer(false), $invoice->customer_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.customer.create')));

echo '</div></div>';

?>
<table class="table" id="items">
    <thead>
    <tr>
        <th width="40%">Item</th>
        <th>Quantity</th>
        <th>Unit Price (KHR)</th>
        <th>Total Price (KHR)</th>
        <th>Action</th>
    </tr>
    </thead>

    <?php
    $index = 0;
    foreach ($invoice_pro as $list) {
        $index += 1;
        echo '<tr class="item_row" >';
        echo '<td>';
        echo Former::select('item[' . $index . ']', '')
            ->id('item_' . $index)
            ->options(LaboList::product(), $list->product_id)
            ->class('select2 item_name');
//            ->required();

        echo '</td>';
        echo '<td>';
        echo Former::text('qty[' . $index . ']', '')
            ->id('qty_' . $index)
            ->value($list->quantity)
            ->class('form-control qty')
            ->data_inputmask('integer');
        echo '</td>';
        echo '<td>';
        echo Former::text('cost[' . $index . ']', '')
            ->id('cost_' . $index)
            ->value($list->price)
            ->class('form-control cost')
            ->data_inputmask('decimal');
        echo '</td>';
        echo '<td>';
        echo Former::text('price[' . $index . ']', '')
            ->id('price_' . $index)
            ->value($list->total)
            ->class('form-control price')
            ->data_inputmask('decimal')
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
    ->value($invoice->total)
    ->data_inputmask('decimal')
    ->append('KHR')
    ->readonly();
echo Former::text('total_usd', '')
    ->value($total_usd)
    ->data_inputmask('decimal')
    ->append('USD')
    ->readonly();
echo Former::checkbox('status', '')
    ->text(' Please check me, if paid.')
    ->check($status);

echo Former::actions()
    ->primary_submit('Update', array('id' => 'submit'))
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
    ->data_inputmask('decimal')
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
    ->data_inputmask('decimal')
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

@stop
