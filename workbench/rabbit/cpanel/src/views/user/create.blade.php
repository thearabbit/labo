@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->action(URL::route('cpanel.user.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';
echo FormProperty::section('General');

echo Former::text('full_name')
    ->required();
echo Former::text('email')
    ->required();
echo Former::select('type')
    ->options(CpanelList::type(false))
    ->placeholder('- Select One -')
    ->required();
echo Former::select('permission[]')
    ->id('permission')
    ->options(CpanelList::permission(false))
    ->multiple()
    ->size(10)
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo FormProperty::section('Security');

echo Former::select('active')
    ->options(CpanelList::active(false))
    ->placeholder('- Select One -')
    ->required();
echo Former::text('username')
    ->autocomplete('off')
    ->required();
echo Former::password('password')
    ->required();
echo Former::password('password_confirmation')
    ->required();
echo Former::password('password_action');

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();

?>

@stop

@section('js')
    @include('cpanel::user.js')
@stop
