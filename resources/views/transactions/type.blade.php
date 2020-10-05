@extends('layouts.app')
@section('title', $goodType)
@section('content')
    @livewire('transactions.builder', ['goodType' => $goodType, 'transactionType' => $transactionType])
@endsection
@section('scripts')
    @parent
    <script>
        $(window).on('load', function () {
            var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

            copyTextareaBtn.addEventListener('click', function (event) {
                var copyTextarea = document.querySelector('.js-copytextarea');
                copyTextarea.select();

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    console.log('Copying text command was ' + msg);
                } catch (err) {
                    console.log('Oops, unable to copy');
                }
            });
        });
    </script>
@endsection
