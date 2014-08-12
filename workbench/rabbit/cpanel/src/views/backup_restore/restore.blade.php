@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->action(URL::route('cpanel.restore.store'))
    ->method('post')
//    ->file()
    ->enctype('multipart/form-data');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::file('restore', 'Restore File')
    ->required();

echo Former::actions()
    ->primary_submit('Restore')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();

?>

@stop
