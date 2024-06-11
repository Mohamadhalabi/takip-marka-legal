@extends('layouts.dashboard.app')
@section('css')
    <style>
        #btn-back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: none;
            box-shadow: 0 4px 9px -4px #dc4c64;
            border-radius: 100%;
            z-index: 999;
            width: 70px;
            height: 70px;
        }
    </style>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // delete local storage 'lastClicked'
            localStorage.removeItem('lastClicked');
        });

        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = localStorage.getItem('lastClicked') || 0;
            document.documentElement.scrollTop = localStorage.getItem('lastClicked') || 0;
        }
        // get lastClicked element position y
        $('.lastClicked').click(function() {
            // redirect to lastClicked element
            let lastClicked = $(this).offset().top;
            localStorage.setItem('lastClicked', lastClicked);
            // get clicked element value 'keyword-id'
            let keywordId = $(this).attr('keyword-id');
            let trademarkID = $(this).attr('trademark-id');

            if (trademarkID != undefined) {
                // redirerct href #trademark-id
                window.location.href = '#trademark-detail-' + trademarkID;
            } else if (keywordId != undefined) {
                // redirerct href #keyword-id
                window.location.href = '#keyword-' + keywordId;
            }
        });
    </script>
@endsection
@section('page-header', __('theme/report.title'))
@section('content')
    @include('dashboard.pages.report.report')
    <!-- Back to top button -->
    <button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection
