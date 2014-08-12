@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.staff.store'))
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
echo Former::text('dob', 'Date Of Birth')
    ->value(date('Y-m-d'))
    ->date_picker();
echo Former::select('status')
    ->options(LaboList::status(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::select('position')
    ->options(LaboList::position(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::textarea('address')
    ->required();
echo Former::text('telephone')
    ->required();
echo Former::text('email');

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
