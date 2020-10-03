@extends('layouts.app')
@section('title', 'Nebulon in The Nebulon Cluster')
@section('menu')
@parent
@endsection
@section('content')
<style type="text/css">
    .solary{
        width: 800px;
        height: 800px;
        position: relative;
        margin: 0 auto;
        background-color: #000000;
        padding: 0;
        transform: scale(1);
    }

    .earth{
        left:391px;
        top:391px;
        height: 18px;
        width: 18px;
        background-color: rgb(115,114,174);
        border-radius: 50%;
        position: absolute;
        margin: 0;
    }

    .venus {
        left:309px;
        top:389px;
        height: 22px;
        width: 22px;
        background-color: rgb(246,157,97);
        border-radius: 50%;
        position: absolute;
        transform-origin: 91px 11px;
        /*animation: rotate 3.84s infinite linear;*/
    }

    .venusOrbit {
        left:320px;
        top:320px;
        height: 160px;
        width: 160px;
        background-color: transparent;
        border-radius: 50%;
        border-style: dashed;
        border-color: gray;
        position: absolute;
        border-width: 1px;
        /*margin: 100px;*/
        /*transform-origin: -75px -75px;*/
        /*animation: rotate 4s infinite linear;*/
        margin: 0px;
        padding: 0px;
    }

    .sun {
        left:10px;
        top:380px;
        height: 90px;
        width: 90px;
        background-color: rgb(248,107,35);
        border-radius: 50%;
        box-shadow: 5px 5px 10px rgb(248,107,35), -5px -5px 10px rgb(248,107,35), 5px -5px 10px rgb(248,107,35), -5px 5px 10px rgb(248,107,35);
        position: absolute;
        margin: 0;
        transform-origin: 390px 10px;
        animation: rotate 512s infinite linear;
    }

    .sunOrbit {
        left:50px;
        bottom:75px;
        height: 670px;
        width: 700px;
        background-color: transparent;
        border-radius: 50%;
        border-style: dashed;
        border-color: gray;
        position: absolute;
        border-width: 1px;
        /*margin: 100px;*/
        /*transform-origin: -75px -75px;*/
        /*animation: rotate 4s infinite linear;*/
        margin: 0px;
        padding: 0px;
    }


    .mars {
        left:222.5px;
        top:392.5px;
        height: 15px;
        width: 15px;
        background-color: rgb(140,119,63);
        border-radius: 50%;
        position: absolute;
        transform-origin: 177.5px 7.5px;
        /*animation: rotate 11.75s infinite linear;*/
    }


    .marsOrbit {
        left:230px;
        top:230px;
        height: 340px;
        width: 340px;
        background-color: transparent;
        border-radius: 50%;
        border-style: dashed;
        border-color: gray;
        position: absolute;
        border-width: 1px;
        /*margin: 100px;*/
        /*transform-origin: -75px -75px;*/
        /*animation: rotate 4s infinite linear;*/
        margin: 0px;
        padding: 0px;
    }

    @keyframes rotate {
        100%{
            transform: rotate(-360deg);
        }
    }
</style>
<div class="solary">
    <div class='earth'></div>

    <div class='venusOrbit'></div>
    <div class='venus'></div>

    <div class='sunOrbit'></div>
    <div class='sun'></div>

    <div class='marsOrbit'></div>
    <div class='mars'></div>

</div>
@endsection
@section('scripts')
    @parent
@endsection
