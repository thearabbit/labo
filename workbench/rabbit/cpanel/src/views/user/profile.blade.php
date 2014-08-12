@extends(Config::get('cpanel::layout'))

@section('content')

<?php
$userType = Auth::user()->type;

echo Former::vertical_open()
    ->action(URL::route('cpanel.profile.update'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';
echo FormProperty::section('General');

echo Former::text('full_name')
    ->value($data->full_name)
    ->required();
echo Former::text('email')
    ->value($data->email)
    ->required();
echo Former::text('username')
    ->autocomplete('off')
    ->value($data->username)
    ->required();
echo FormProperty::section('Security');
echo Former::password('old_password')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::password('password', 'New password')
    ->required();
echo Former::password('password_confirmation')
    ->required();

if ($userType == 'Super' or $userType == 'Admin') {
    echo Former::password('password_action');
} else { // Guest
    echo Former::password('password_action')
        ->disabled();
}

echo Former::actions()
    ->primary_submit('Update')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();

?>

@stop
