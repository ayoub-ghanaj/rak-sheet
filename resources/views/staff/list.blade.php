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
            <span class="title">الرئيسية</span>
        </a>
    </li>
    <li >
        <a href="/app/add">
            <span class="icon">
                <ion-icon name="add-circle-outline"></ion-icon>
            </span>
            <span class="title">اضافة</span>
        </a>
    </li>
    @if($user->rank =="admin")
    <li>
        <a href="/app/subjects">
            <span class="icon">
                <ion-icon name="bookmarks-outline"></ion-icon>
            </span>
            <span class="title">المواد التقويمية </span>
        </a>
    </li>
    @endif
    <li class="hovered">
        <a href="/app/list">
            <span class="icon">
                <ion-icon name="list"></ion-icon>
            </span>
            <span class="title">لائحة</span>
        </a>
    </li>

    <li class="delete_all">
        <a>
            <span class="icon">
                <ion-icon name="trash-outline"></ion-icon>
            </span>
            <span class="title">حذف قاعدة اللبيانات</span>
        </a>
    </li>

    <li>
        <a href="/app/logout">
            <span class="icon">
                <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">تسجيل خروج</span>
        </a>
    </li>
@endsection
{{-- {{ dd($data) }} --}}

@section('content')
    <h2 class="" style="margin-left: 40px; font-size: 30px;">بريدي واصل</h2>

    <style>



        .parent {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-template-rows: repeat(5, 1fr);
            grid-column-gap: 14px;
            grid-row-gap: 20px;
            height: 80vh;
        }
            .div7 { grid-area: 1 / 1 / 6 / 7;
                    background: #F4F4F4;
                    border-radius: 32px;
                    margin: 10px;
                }
            .div1 { grid-area: 2 / 2 / 3 / 3; }
            .div2 { grid-area: 2 / 3 / 3 / 4; }
            .div3 { grid-area: 2 / 4 / 3 / 5; }
            .div4 { grid-area: 2 / 5 / 3 / 6; }
            .div5 { grid-area: 3 / 4 / 4 / 5;
                display: grid;
                align-items: center;
                justify-content: center; }
            .div6 { grid-area: 3 / 3 / 4 / 4;
                display: grid;
                align-items: center;
                justify-content: center; }


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
        <div class="div7"> </div>
        <div class="div1">
            <select class="custom-select year-sel">
                <option selected style="display: none;">اختر السنة</option>
            </select>
        </div>
        <div class="div2">
            <select class="custom-select grade-sel">
                <option selected style="display: none;">اختر المستوى</option>
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
                <button class="custom-button select-btn">لائحة تلاميذ</button>
        </div>
        <div class="div6">
                <button class="custom-button stats-btn">احصائيات</button>
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
  function populateGradeSelect(selectedYear) {
    var gradeSelect = $(".grade-sel");
    gradeSelect.empty().append($('<option>', {
      value: "",
      text: "اختر المتسوى"
    }));
    var grades = [];
    $.each(data, function(index, item) {
      if (item.year === selectedYear && $.inArray(item.grade_drop, grades) === -1) {
        grades.push(item.grade_drop);
        gradeSelect.append($('<option>', {
          value: item.grade_drop,
          text: item.grade_drop
        }));
      }
    });
  }
  function populateClassSelect( selectedYear,selectedGrade) {
    var classSelect = $(".class-sel");
    classSelect.empty().append($('<option>', {
      value: "",
      text: "اختر الفصل"
    }));

    var classes = [];
    $.each(data, function(index, item) {
      if (item.year === selectedYear && item.grade_drop === selectedGrade && $.inArray(item.class_drop, classes) === -1) {
        classes.push(item.class_drop);
        classSelect.append($('<option>', {
          value: item.class_drop,
          text: item.class_drop
        }));
      }
    });
  }
  // Function to populate the title select based on the selected year and class
  function populateTitleSelect(selectedYear, selectedClass , selectedGrade) {
    var titleSelect =  $(".semester-sel");
    titleSelect.empty().append($('<option>', {
      value: "",
      text: "اختر دورة"
    }));
    var titles = [];

    $.each(data, function(index, item) {
      if (item.year === selectedYear && item.class_drop === selectedClass && item.grade_drop === selectedGrade && $.inArray(item.title1, titles) === -1) {
        titles.push(item.title1);
        titleSelect.append($('<option>', {
          value: item.title1,
          text: translateTitle(item.title1)
        }));
      }
    });
  }

  // Document ready event
  $(document).ready(function() {
    $(".delete_all").click(()=>{
                    Swal.fire({
                    title: 'تاكيد حذف قاعدة البيانات',
                    html: `
                    <form id="passwordForm"  action="/app/delete_all" method="post" style="">
                        @csrf
                        <input type="password" name="password" id="password" placeholder="Password" required style="display: block; margin: auto; margin-bottom: auto; margin-bottom: 17px;">
                        <input type="submit"  value="تاكيد"/>
                    </form>
                    `,
                    confirmButtonText: 'تاكيد',
                    cancelButtonText: 'الغاء',
                    showConfirmButton: false,
                    showCancelButton: false,
                }).then((result) => {
                });
                })
    populateYearSelect();

    // Year select change event
    $(".year-sel").change(function() {
      var selectedYear = $(this).val();
      if (selectedYear !== '') {
        populateGradeSelect(selectedYear);
        $(".grade-sel").trigger("change");
        $(".class-sel").trigger("change");
      } else {
        $(".grade-sel").empty().append($('<option>', {
        value: "",
        text: "اختر المستوى"
        }));
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
      var selectedgrade = $(".grade-sel").val();
      var selectedClass = $(this).val();
      if (selectedYear !== '' && selectedClass !== '') {
        populateTitleSelect(selectedYear, selectedClass, selectedgrade);

      } else {
        $(".semester-sel").empty().append($('<option>', {
          value: "",
          text: "اختر دورة"
        }));
      }
    });


    $(".grade-sel").change(function() {
      var selectedYear = $(".year-sel").val();
      var selectedClass = $(this).val();
      if (selectedYear !== '' && selectedClass !== '') {
          populateClassSelect(selectedYear, selectedClass);
          $(".class-sel").trigger("change");
      } else {
        $(".class-sel").empty().append($('<option>', {
          value: "",
          text: "اختر دورة"
        }));
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
        let grade =  $(".grade-sel").val();
        if(year && class_val && semester && grade){

            // Create the URLSearchParams object
            const params = new URLSearchParams({
            year: year,
            class: class_val,
            semester: semester,
            grade : grade
            });

            // Create the final URL with the parameters
            const url = `/app/list/class?${params.toString()}`;

            // Navigate to the URL
            window.location.href = url;
        }
    });
    $(".stats-btn").click(()=>{
        let year = $(".year-sel").val();
        let class_val = $(".class-sel").val();
        // let semester =  $(".semester-sel").val();
        let grade =  $(".grade-sel").val();
        if(year && class_val && grade){

            // Create the URLSearchParams object
            const params = new URLSearchParams({
            year: year,
            class: class_val,
            // semester: semester,
            grade : grade
            });

            // Create the final URL with the parameters
            const url = `/app/list/class_stats?${params.toString()}`;

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
