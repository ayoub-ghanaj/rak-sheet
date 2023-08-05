<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whatschool</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ======= Styles/js ====== -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/raphael@2.3.0/raphael.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/justgage@1.4.2/justgage.min.js"></script>
    <style>
        .table {
            margin: 20px auto;
            width: 85%;
        }

        .table .headeer {
            background-color: #185327;
            border-radius: 5px;
            display: flex;
            opacity: .9;
            margin-bottom: 10px;
            width: 100%;
        }

        .table .headeer {
            padding: 10px;
            color: #f5f5f5;
        }

        .table .tableau .info span {
            padding: 12px 8px;
            color: #185327;
            background-color: transparent;
            cursor: pointer;

        }

        .table .tableau .info {
            display: flex;
            transition: all 150ms ease;
            margin-bottom: 5px;
            width: 100%;
            border: none;
            border-bottom: 1px solid rgba(42, 33, 133, 0.1);
        }


        .info:hover {
            background-color: rgba(42, 33, 133, 0.2);
            transform: scale(1);
        }

        .info:focus-within~.info,
        .info:hover~.info {
            transform: translateY(10px);
        }

        .btnReponde {
            margin: auto;
            color: #185327;
            font-size: 20px;
            border: none;
            outline: none;
            transition: all 150ms ease-in-out;
            background-color: transparent;
            padding: 5px 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 3px;
        }

        .btnReponde:hover {
            color: #f5f5f5;
            background-color: #185327;
        }

        .time {
            padding: 12px 8px;
            color: #185327;
            background-color: transparent;
            cursor: pointer;
            align-items: center;
            border: 3px solid #185327;
        }
    </style>

</head>

<body>
    <!-- =============== Navigation ================ -->

    <div class="container">
        <div class="navigation">
            @yield('img')

            <ul class="side-list">


                <!--content-->
                @yield('list')
                <!-- content-->


            </ul>
        </div>


        <!--content-->
        <div class="container">
            <div class="main">
                <div class="topbar">
                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>
                </div>
                <div class="main_container">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- content-->



        <!-- =========== Scripts =========  -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script></script>

        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        @stack('scripts')
</body>

</html>
