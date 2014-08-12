@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.product.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::select('category_id', 'Category')
    ->options(LaboList::category(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::text('kh_name')
    ->required();
echo Former::text('en_name')
    ->required();
echo Former::select('child')
    ->options(LaboList::child(false))
    ->placeholder('- Select One -')
//    ->class('select2')
    ->required();
echo Former::text('normal_value')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('price')
    ->data_inputmask('integer')
    ->required();
echo Former::select('fee_type')
    ->options(LaboList::feeType(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::text('fee')
    ->data_inputmask('decimal')
    ->required();

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop

@section('js')
@include('labo::product.js')
@stop