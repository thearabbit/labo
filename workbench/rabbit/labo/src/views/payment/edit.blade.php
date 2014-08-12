@extends(Config::get('cpanel::layout'))

@section('content')

<?php
echo Former::vertical_open()
    ->id('my_form')
    ->action(URL::route('labo.payment.update', $data->id))
    ->method('put');

echo '<div class="row">
        <div class="col-md-6">';

echo Former::text('payment_date')
    ->value($data->payment_date)
    ->date_picker()
    ->required();
echo Former::select('invoice_id')
    ->options(LaboList::invoice(false, $data->invoice_id), $data->invoice_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required();
echo Former::text('overdue_amount')
    ->value(round($data->overdue_amount))
    ->data_inputmask('integer')
    ->readonly()
    ->required();
echo Former::text('paid_amount')
    ->value(round($data->paid_amount))
    ->data_inputmask('integer')
    ->readonly()
    ->required();

echo '</div>';
echo '<div class="col-md-6">';

echo Former::text('balance')
    ->value(round($data->balance))
    ->data_inputmask('integer')
    ->readonly()
    ->required();
echo Former::select('staff_id')
    ->options(LaboList::staff(false), $data->staff_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->required()
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.staff.create')));
echo Former::select('exchange_id')
    ->options(LaboList::exchange(false), $data->exchange_id)
    ->placeholder('- Select One -')
    ->class('select2')
    ->append(FormProperty::inputLinkAddOn('+', URL::route('labo.exchange.create')));

echo Former::actions()
    ->primary_submit('Update')
    ->inverse_reset('Reset');

echo '</div></div>';

echo Former::close();
?>
@stop

@section('js')
@include('labo::payment.js')
@stop
