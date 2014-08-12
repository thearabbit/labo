@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.report-fee_balance.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::select('report_type')
    ->options(LaboList::reportType(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::select('staff_id', 'Staff')
    ->options(LaboList::staff(false, true))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::select('agent_id', 'Agent')
    ->options(LaboList::agent(false, true))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::select('customer_id', 'Customer')
    ->options(LaboList::customer(false, true))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('date')
    ->value($date)
    ->date_picker()
    ->required();
echo Former::select('exchange_id', 'Exchange')
    ->options(LaboList::exchange(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();


echo Former::actions()
    ->primary_submit('Export')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop
