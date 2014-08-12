@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->action(URL::route('cpanel.company.update', $data->id))
    ->method('put');

echo '<div class="row">
        <div class="col-md-6">';
echo FormProperty::section('General');

echo Former::textarea('kh_name')
    ->value($data->kh_name)
    ->required();
echo Former::text('kh_short_name')
    ->value($data->kh_short_name)
    ->required();
echo Former::textarea('en_name')
    ->value($data->en_name)
    ->required();
echo Former::text('en_short_name')
    ->value($data->en_short_name)
    ->required();
echo Former::textarea('kh_address')
    ->value($data->kh_address)
    ->required();
echo Former::textarea('en_address')
    ->value($data->en_address)
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo FormProperty::section('Contract');
echo Former::text('telephone')
    ->value($data->telephone)
    ->required();
echo Former::text('email')
    ->value($data->email);
echo Former::text('website')
    ->value($data->website);
echo Former::text('logo')
    ->value($data->logo);

echo Former::actions()
    ->primary_submit('Update')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();

?>

@stop
