@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->action(URL::route('cpanel.backup.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('name', 'Backup name')
    ->value($name)
    ->append('DateTime')
    ->readonly()
    ->required();

echo Former::actions()
    ->primary_submit('Backup')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();

?>

@stop
