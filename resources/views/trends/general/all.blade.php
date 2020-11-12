@extends('layouts.app')
@section('pageTitle', 'Trends')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<style>
    .card {
        width: 20em;
        height: 20em;
        padding-bottom: 1em;
    }
</style>
@section('content')
@livewire('trends.charts')
@endsection
