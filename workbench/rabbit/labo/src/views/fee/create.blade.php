@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.fee.store'))
    ->method('post');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('fee_date')
    ->value(date('Y-m-d'))
    ->date_picker()
    ->required();
echo Former::select('agent_id', 'Agent')
    ->options(LaboList::agent(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.agent.create')));
echo Former::select('invoice_id')
    ->options(array())
//    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::text('overdue_amount')
    ->data_inputmask('integer')
    ->readonly()
    ->required();
echo Former::text('paid_amount')
    ->data_inputmask('integer')
    ->readonly()
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('balance')
    ->data_inputmask('integer')
    ->readonly()
    ->required();
echo Former::select('staff_id')
    ->options(LaboList::staff(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.staff.create')));
echo Former::select('exchange_id')
    ->options(LaboList::exchange(false))
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.exchange.create')));

echo Former::actions()
    ->primary_submit('Create')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop

@section('js')
@include('labo::fee.js')
@stop
