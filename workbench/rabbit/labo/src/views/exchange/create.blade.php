@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.exchange.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('exchange_date')
    ->value(date('Y-m-d'))
    ->date_picker()
    ->required();
echo Former::text('usd', 'USD Amount')
    ->data_inputmask('decimal')
    ->required();
echo Former::text('khr', 'KHR Amount')
    ->data_inputmask('decimal')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::textarea('des', 'Description');

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
