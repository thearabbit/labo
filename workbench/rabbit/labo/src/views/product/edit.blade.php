@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.product.update', $data->id))
    ->method('put');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::select('category_id', 'Category')
    ->options(LaboList::category(false), $data->category_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::text('kh_name')
    ->value($data->kh_name)
    ->required();
echo Former::text('en_name')
    ->value($data->en_name)
    ->required();
echo Former::select('child')
    ->options(LaboList::child(false), $data->child)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::text('normal_value')
    ->value($data->normal_value)
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('price')
    ->value(round($data->price))
    ->data_inputmask('integer')
    ->required();
echo Former::select('fee_type')
    ->options(LaboList::feeType(false), $data->fee_type)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();

echo Former::text('fee')
    ->value($data->fee)
    ->data_inputmask('decimal')
    ->required();

echo Former::actions()
    ->primary_submit('Updte')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop

@section('js')
@include('labo::product.js')
@stop