@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.exchange.update', $data->id))
    ->method('put');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('exchange_date')
    ->value($data->exchange_date)
    ->date_picker()
    ->required();
echo Former::text('usd', 'USD Amount')
    ->value($data->usd)
    ->data_inputmask('decimal')
    ->required();
echo Former::text('khr', 'KHR Amount')
    ->value($data->khr)
    ->data_inputmask('decimal')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::textarea('des', 'Description')
    ->value($data->des);

echo Former::actions()
    ->primary_submit('Update')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
