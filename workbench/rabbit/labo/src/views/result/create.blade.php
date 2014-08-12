@extends(Config::get('cpanel::layout'))

@section('css')
@include('labo::result.css')
@stop

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.result.store'))
    ->method('post');

echo FormProperty::section('Invoice Info');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::hidden('invoice_id')
    ->value($invoice->id);

echo '<dl class="dl-horizontal pull-left">';
echo '<dt>Invoice ID: </dt>';
echo '<dd>' . $invoice->id . '</dd>';
echo '<dt>Invoice Date: </dt>';
echo '<dd>' . $invoice->invoice_date . '</dd>';
echo '<dt>Invoice Status: </dt>';
echo '<dd>' . $invoice->status . '</dd>';
echo '</dl>';

echo '</div>';
echo '<div class="col-md-6">';

echo '<dl class="dl-horizontal">';
echo '<dt>Staff: </dt>';
echo '<dd>' . $invoice->s_kh_name . '</dd>';
echo '<dt>Agent: </dt>';
echo '<dd>' . $invoice->a_kh_name . '</dd>';
echo '<dt>Customer: </dt>';
echo '<dd>' . $invoice->c_kh_name . '</dd>';
echo '</dl>';

echo '</div></div>';
echo FormProperty::section('Result');

// Break result to 2 columns
echo '<div class="row">
        <div class="col-md-12">';

foreach ($products as $product) {
    // Check has child
    if ($product->p_child == 'Yes') {
        // Get child
        $children = \Rabbit\Labo\ProductChildModel::where('product_id', $product->product_id)
            ->orderBy('id')
            ->get();

        // Set fieldset
        echo '<fieldset class="border">
                <legend class="border">' . $product->p_en_name . '</legend>';
        foreach ($children as $child) {
            echo Former::text('product_' . $product->product_id . '[' . $child->id . ']', $child->en_name)
                ->append($child->normal_value);

        }
        echo '</fieldset>';
    } else {
        echo Former::text('product_' . $product->product_id, $product->p_en_name)
            ->append($product->p_normal_value)
            ->required();
    }
}

echo '</div></div>';

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo Former::close();
?>

@stop
