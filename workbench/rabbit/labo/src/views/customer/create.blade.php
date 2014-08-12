@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.customer.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('kh_name')
    ->required();
echo Former::text('en_name')
    ->required();
echo Former::select('sex')
    ->options(LaboList::sex(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::number('age')
    ->min(0)
    ->max(150)
    ->step(0.1)
    ->required();
echo Former::select('status')
    ->options(LaboList::status(false))
    ->placeholder('- Select One -')
    ->class('select2');

echo '</div>';
echo '<div class="col-md-6">';

echo Former::textarea('address')
    ->required();
echo Former::text('telephone');
echo Former::text('email');

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
