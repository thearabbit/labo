@extends(Config::get('cpanel::layout'))

@section('content')

@if($form=='create')
    @include('labo::product_child.create')
@else
    @include('labo::product_child.edit')
@endif

<?php
echo $datatable;
?>
@stop