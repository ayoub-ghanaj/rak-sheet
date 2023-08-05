<?php
declare(strict_types=1);
?>
@extends('template')


@section('img')
<img src="{{asset('assets/img/logo.png')}}" class="logo"/>
@endsection
@section('list')



    <li >
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
    <li class="hovered">
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
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: repeat(7, 1fr);
            grid-column-gap: 12px;
            grid-row-gap: 13px;
            height: 100vh;
        }

            .div1 { grid-area: 1 / 1 / 8 / 6;
                background: #F4F4F4;
                        border-radius: 32px;
                        margin: 10px; }
            .div2 { grid-area: 2 / 2 / 3 / 3; }
            .div3 { grid-area: 2 / 3 / 3 / 4; }
            .div4 { grid-area: 2 / 4 / 3 / 5; }
            .div5 { grid-area: 3 / 3 / 4 / 4;
                    display: grid;
                align-items: center;
                justify-content: center;
                }

                /* Style the dropdown arrow */
            .custom-select {
                appearance: none; /* Hide the default arrow icon on Chrome and Safari */
                -webkit-appearance: none; /* Hide the default arrow icon on newer versions of Chrome */
                -moz-appearance: none; /* Hide the default arrow icon on Firefox */
                background-image: url('path-to-your-custom-arrow-icon.png'); /* Use a custom arrow icon */
                background-repeat: no-repeat;
                background-position: right center;
                padding-right: 20px; /* Add some space for the arrow */
            }

            /* Style the select box */
            .custom-select {
                padding: 10px; /* Add padding for better visual appearance */
                border: 1px solid #ccc; /* Add a border */
                border-radius: 5px; /* Round the corners */
                font-size: 16px; /* Set font size */
                width: 200px; /* Set a fixed width */
            }

            /* Style the options */
            .custom-select option {
                padding: 5px; /* Add padding for better visual appearance */
            }
            .custom-button {
                padding: 10px 20px; /* Add padding to make the button more clickable */
                border: none; /* Remove the default button border */
                border-radius: 5px; /* Round the button corners */
                background-color: #007bff; /* Set the background color */
                color: #fff; /* Set the text color */
                font-size: 16px; /* Set the font size */
                cursor: pointer; /* Add a pointer cursor on hover */
                transition: background-color 0.2s ease; /* Add a smooth transition effect */
            }

            /* Add hover effect */
            .custom-button:hover {
                background-color: #0056b3; /* Change the background color on hover */
            }
    </style>
    <div class="parent">
        <div class="div1"> </div>
        <div class="div2">
            <select class="custom-select year-sel">
                <option selected style="display: none;">اختر السنة</option>
            </select>
        </div>
        <div class="div3">
            <select class="custom-select class-sel">
                <option selected style="display: none;">اختر الفصل</option>
            </select>
        </div>
        <div class="div4">
            <select class="custom-select semester-sel">
                <option selected style="display: none;">اختر دورة</option>
            </select>
        </div>
        <div class="div5">
                <button class="custom-button select-btn">التاكيد</button>
        </div>
    </div>
    @push('scripts')
        <script>
            const data = {!! json_encode($list) !!};
             // Function to populate the year select
             function translateTitle(title) {
                if (title.includes("THIRD SEMESTER")) {
                    return "الفصل الثالث";
                } else if (title.includes("SECOND SEMESTER")) {
                    return "الفصل الثاني";
                } else if (title.includes("FIRST SEMESTER")) {
                    return "الفصل الأول";
                } else if (title.includes("FOURTH SEMESTER")) {
                    return "الفصل الرابع";
                } else {
                    return title;
                }
            }
  function populateYearSelect() {
    var yearSelect = $(".year-sel");
    var years = [];
    $.each(data, function(index, item) {
      if ($.inArray(item.year, years) === -1) {
        years.push(item.year);
        yearSelect.append($('<option>', {
          value: item.year,
          text: item.year
        }));
      }
    });
  }

  // Function to populate the class select based on the selected year
  function populateClassSelect(selectedYear) {
    var classSelect = $(".class-sel");
    classSelect.empty().append($('<option>', {
      value: "",
      text: "اختر الفصل"
    }));

    var classes = [];
    $.each(data, function(index, item) {
      if (item.year === selectedYear && $.inArray(item.class, classes) === -1) {
        classes.push(item.class);
        classSelect.append($('<option>', {
          value: item.class,
          text: item.class
        }));
      }
    });
  }

  // Function to populate the title select based on the selected year and class
  function populateTitleSelect(selectedYear, selectedClass) {
    var titleSelect =  $(".semester-sel");
    titleSelect.empty().append($('<option>', {
      value: "",
      text: "اختر دورة"
    }));

    $.each(data, function(index, item) {
      if (item.year === selectedYear && item.class === selectedClass) {
        titleSelect.append($('<option>', {
          value: item.title1,
          text: translateTitle(item.title1)
        }));
      }
    });
  }

  // Document ready event
  $(document).ready(function() {
    populateYearSelect();

    // Year select change event
    $(".year-sel").change(function() {
      var selectedYear = $(this).val();
      if (selectedYear !== '') {
        populateClassSelect(selectedYear);
        $(".class-sel").trigger("change")
      } else {
        $(".class-sel").empty().append($('<option>', {
          value: "",
          text: "اختر الفصل"
        }));
        $(".semester-sel").empty().append($('<option>', {
          value: "",
          text: "اختر دورة"
        }));
      }
    });

    // Class select change event
    $(".class-sel").change(function() {
      var selectedYear = $(".year-sel").val();
      var selectedClass = $(this).val();
      if (selectedYear !== '' && selectedClass !== '') {
        populateTitleSelect(selectedYear, selectedClass);
      } else {
        $(".semester-sel").empty().append($('<option>', {
          value: "",
          text: "اختر دورة"
        }));
      }
    });
    $(".select-btn").click(()=>{
        let year = $(".year-sel").val();
        let class_val = $(".class-sel").val();
        let semester =  $(".semester-sel").val();
        if(year && class_val && semester){
           
            // Create the URLSearchParams object
            const params = new URLSearchParams({
            year: year,
            class: class_val,
            semester: semester
            });

            // Create the final URL with the parameters
            const url = `/app/list/class?${params.toString()}`;

            // Navigate to the URL
            window.location.href = url;
        }
    });
  });

        </script>
    @endpush


    </section>


    <!-- ========================= Search barre ==================== -->





@endsection
