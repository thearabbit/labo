@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.category.update', $data->id))
    ->method('put');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('kh_name')
    ->value($data->kh_name)
    ->required();
echo Former::text('en_name')
    ->value($data->en_name)
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::textarea('des')
    ->value($data->des);

echo Former::actions()
    ->primary_submit('Update')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
