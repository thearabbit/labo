@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.category.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('kh_name')
    ->required();
echo Former::text('en_name')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::textarea('des');

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
