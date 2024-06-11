<html>

<head>
    <title>
        Test Report
    </title>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style type="text/css">
        h1.test-results-header {
            text-align: center;
        }

        td {
            border-bottom: 1px solid gray;
        }

        .test-result-table {
            border: 1px solid black;
            width: auto;
        }

        .test-result-table-header-cell {
            border-bottom: 1px solid black;
            background-color: silver;
        }

        .test-result-step-command-cell {

            border-bottom: 1px solid gray;
        }

        .test-result-step-description-cell {

            border-bottom: 1px solid gray;
        }

        .test-result-step-result-cell-ok {

            border-bottom: 1px solid gray;
            background-color: green;
        }

        .test-result-step-result-cell-failure {

            border-bottom: 1px solid gray;
            background-color: red;
        }

        .test-result-step-result-cell-passed {

            border-bottom: 1px solid gray;
            background-color: yellow;
        }

        .test-result-step-result-cell-notperformed {

            border-bottom: 1px solid gray;
            background-color: white;
        }

        .test-result-describe-cell {
            background-color: tan;
            font-style: italic;
        }

        .test-cast-status-box-ok {
            border: 1px solid black;
            float: left;
            margin-right: 10px;
            width: 45px;
            height: 25px;
            background-color: green;
        }

        /* tr hover */
        .test-result-step-row:hover {
            background-color: #f1abab !important;
        }

        .text-center {
            text-align: center;
        }

        #test table{
            margin-top:20px;
            padding-top:20px;
        }

        /* .dataTables_info {
            position: fixed;
            bottom: 60;
            right:30;
        }

        div#test_paginate {
            position: fixed;
            bottom: 15;
            right: 10;
        } */
        #test_length{
            margin-bottom:10px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#test').DataTable({
                "pageLength": 20,
                "autoWidth": true,
            });
        });
    </script>
</head>

<body>
    @yield('content')

</body>

</html>
