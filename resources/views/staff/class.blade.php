<?php
declare(strict_types=1);
?>
@extends('template')


@section('img')
<img src="{{asset('assets/img/logo.png')}}" class="logo"/>
@endsection
@section('list')
    <script>
        $(document).ready(()=>{
            var user = JSON.parse(`{!! json_encode($user, JSON_HEX_TAG) !!}`);
            console.log("user");
            console.log(user);

        })
    </script>



    <li class="hovered">
        <a href="/app/home">
            <span class="icon">
                <ion-icon name="home-outline"></ion-icon>
            </span>
            <span class="title">home</span>
        </a>
    </li>
    <li >
        <a href="/app/add">
            <span class="icon">
                <ion-icon name="add-circle-outline"></ion-icon>
            </span>
            <span class="title">add</span>
        </a>
    </li>
    <li>
        <a href="/app/list">
            <span class="icon">
                <ion-icon name="list"></ion-icon>
            </span>
            <span class="title">list</span>
        </a>
    </li>
    <li>
        <a href="../app/logout">
            <span class="icon">
                <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Sign Out</span>
        </a>
    </li>
@endsection
{{-- {{ dd($data) }} --}}

@section('content')
    <h2 class="" style="margin-left: 40px; font-size: 30px;">بريدي واصل</h2>

    <style>
        .parent {
            height: 100vh;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: repeat(6, 1fr);
            grid-column-gap: 0px;
            grid-row-gap: 0px;
        }

        .div1 { grid-area: 1 / 1 / 8 / 6;
            background: #F4F4F4;
            border-radius: 32px;
            margin: 10px;
        }
        .div2 {   grid-area: 3 / 2 / 5 / 5;
            border: #d2d2d2 1px solid;
            border-radius: 26px;
            margin-top: 12px;
            background: #fff6;
        }
        .div3 {    grid-area: 6 / 2 / 8 / 5;
            border: #d2d2d2 1px solid;
            border-radius: 26px;
            margin-top: 12px;
            background: #fff6;
        }
        .div4 {  grid-area: 1 / 1 / 3 / 3;
            border: #d2d2d2 1px solid;
            border-radius: 26px;
            margin-top: 12px;
            margin-left: 12px;
            background: #fff6; }
        .div5 { grid-area: 1 / 4 / 3 / 6;
            border: #d2d2d2 1px solid;
            border-radius: 26px;
            margin-top: 12px;
            margin-right: 12px;
            background: #fff6; }
        .div6 { grid-area: 5 / 4 / 7 / 6; }

    </style>
    <div class="parent">
        <div class="div1"> </div>
        <div class="div2">
            <canvas id="lineChart1" width="800" height="400"></canvas>
        </div>
        <div class="div3">
            <canvas id="lineChart2" width="800" height="400"></canvas>
        </div>
        <div class="div4" id="gauge1">

        </div>
        <div class="div5" id="gauge2">

        </div>
        <div class="div6">

        </div>
    </div>
    @push('scripts')
        <script>
            const data = {!! json_encode($data) !!};
            const sub = {!! json_encode($sub) !!};

            const red = "#ea0f0f";
            const yellow = "#e7dc38";
            const green = "#47db3a";
            function getColor(value1, value2) {
                const percentage = (value1 / value2) * 100;
                if (value1 === value2) {
                    return green;
                } else if (percentage >= 75) {
                    return red;
                } else if (percentage > 25) {
                    return green;
                } else {
                    return yellow;
                }
            }
            $(()=>{
                console.log(data);

                const gauge1 = new JustGage({
                    id: "gauge1",
                    value: data[3][0].new_added_count,
                    min: 0,
                    max: sub?data[3][0].new_added_count:200,
                    title: "Sheets count",
                    label: "sheets",
                    valueFontColor: "#4c8f46",
                    valueFontFamily: "Arial",
                    gaugeColor: "#ddd",
                    levelColors: [`${getColor(data[3][0].new_added_count, sub?data[3][0].new_added_count:200)}`],
                });
                const gauge2 = new JustGage({
                    id: "gauge2",
                    value: data[2][0].new_added_count,
                    min: 0,
                    max: sub?data[2][0].new_added_count:500,
                    title: "Students count",
                    label: "Students",
                    valueFontColor: "#4c8f46",
                    valueFontFamily: "Arial",
                    gaugeColor: "#ddd",
                    levelColors: [`${getColor(data[2][0].new_added_count, sub?data[2][0].new_added_count:200)}`],
                });

                chart1();
                chart2();

            })
            function getRandomColor() {
                return '#' + Math.floor(Math.random()*16777215).toString(16);
            }
            function chart1(){
                let data1 = data[0];
                // Extract unique years and subjects from the data
                const years = [...new Set(data1.map(item => item.year))];
                const subjects = [...new Set(data1.map(item => item.subject_ar))];

                // Create an empty object to store the grades for each year and subject
                const grades = {};
                years.forEach(year => {
                grades[year] = {};
                subjects.forEach(subject => {
                    const item = data1.find(d => d.year === year && d.subject_ar === subject);
                    grades[year][subject] = item ? item.avg_grade_short : 0;
                });
                });

                // Create datasets for Chart.js
                const datasets = subjects.map(subject => ({
                label: subject,
                data: years.map(year => grades[year][subject]),
                fill: false,
                borderColor: getRandomColor(),
                borderWidth: 2
                }));
                const lineChart = new Chart(document.getElementById("lineChart1"), {
                type: 'line',
                data: {
                    labels: years,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                    x: {
                        title: {
                        display: true,
                        text: 'Years'
                        }
                    },
                    y: {
                        title: {
                        display: true,
                        text: 'Grades'
                        }
                    }
                    }
                }
                });
            }
            function chart2(){
                let data1 = data[1];
                // Extract unique years and subjects from the data
                const years = [...new Set(data1.map(item => item.year))];
                const subjects = [...new Set(data1.map(item => item.subject_ar))];

                // Create an empty object to store the grades for each year and subject
                const grades = {};
                years.forEach(year => {
                grades[year] = {};
                subjects.forEach(subject => {
                    const item = data1.find(d => d.year === year && d.subject_ar === subject);
                    grades[year][subject] = item ? item.count_below_10 : 0;
                });
                });

                // Create datasets for Chart.js
                const datasets = subjects.map(subject => ({
                label: subject,
                data: years.map(year => grades[year][subject]),
                fill: false,
                borderColor: getRandomColor(),
                borderWidth: 2
                }));
                const lineChart = new Chart(document.getElementById("lineChart2"), {
                type: 'line',
                data: {
                    labels: years,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                    x: {
                        title: {
                        display: true,
                        text: 'Years'
                        }
                    },
                    y: {
                        title: {
                        display: true,
                        text: 'Grades'
                        }
                    }
                    }
                }
                });
            }
        </script>
    @endpush


    </section>


    <!-- ========================= Search barre ==================== -->





@endsection