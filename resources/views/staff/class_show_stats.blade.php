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
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(8, 1fr);
    grid-column-gap: 4px;
    grid-row-gap: 70px;
    height:100vh;
    }


    .div1 {  grid-area: 1 / 1 / 6 / 6;
            background-color: #f8f8f8; /* Light gray background */
            padding: 20px; /* Add some padding around the content */
            border: 1px solid #ccc; /* Add a border to further separate it from the background */
            border-radius: 8px; /* Add some border radius to make it look more rounded */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow to give it depth*/
            height:100vh;
          }
        .div2 { grid-area: 1 / 1 / 3 / 6; }
        .div3 { grid-area: 3 / 1 / 6 / 5; }
.div4 { grid-area: 3 / 5 / 6 / 6;
    overflow-y: scroll;
  height: 59vh; } 

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
            .custom-select ,input {
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
            table {
            width: 100%;
            border-collapse: collapse;
            }

            th, td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
                width: min-content;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .card {
              width: 200px;
              height: 100px;
              border: 1px solid #ccc;
              border-radius: 8px;
              padding: 10px;
              text-align: center;
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .small-title {
              font-size: 12px;
              color: #666;
              margin-bottom: 5px;
            }

            .value {
              font-size: 24px;
              font-weight: bold;
              margin-bottom: 10px;
            }

            .main-title {
              font-size: 16px;
              color: #333;
            }

            .card-scroll-container {
  overflow-x: auto;
  white-space: nowrap;
  padding: 10px;
}

.card-container {
  display: inline-flex;
  gap: 20px;
  flex-wrap: nowrap;

}

.card {
  min-width: 200px; /* Minimum width for each card */
  flex-shrink: 0; /* Prevent cards from shrinking */
  height: 150px;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  background-color: #dadada40;
}

.card-id {
  font-size: 12px;
  color: #666;
}

.card-name {
  font-size: 18px;
  font-weight: bold;
  margin: 10px 0;
}

.card-button {
  padding: 8px 12px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

        .succ{
            padding: 10px;
            border: #00000030 1px solid;
            border-radius: 12px;
        }
    </style>


    <div class="parent">
        <div class="div1"> </div>
        <div class="div2 " style="padding: 10px;">
            <div class="succ">
                <h4> لائحة الطلبة المتفوقين </h4>
                <div class="card-scroll-container">
                  <div class="card-container succ-cards">
                    <!-- Cards will be dynamically added here -->
                  </div>
                </div>
            </div>
        </div>
        <div class="div3">

        </div>
        <div class="div4">
            <table border="1">
                <thead>
                    <tr>
                        <th>اسم</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="users_table" >

                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            const data = {!! json_encode($data) !!};
            const id = 0 ;
            const user = JSON.parse(`{!! json_encode($user, JSON_HEX_TAG) !!}`);
            const JPA_list = [];
            const Subjects_list = [];
            $(()=>{

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
                const  all_students = Object.keys(data);

                all_students.forEach((d,i)=>{
                    JPA_list.push( { id : d , jpa : data[d].semester_subjects.find(subject => subject.subject === "JPA").total})
                    Subjects_list.push({id : d , table:grab_data(data[d])});

                    console.log(data[d]);
                    console.log(Subjects_list);
                    console.info(i);
                })

                JPA_list.sort((a, b) => b.jpa - a.jpa);
                for(let i = 0 ; i<10 && i< JPA_list.length ;i++){
                    $(".succ-cards").append(`
                    <div class="card">
                        <div class="card-id">الترتيب:</div>
                        <div class="card-name">${(i+1)}</div>
                        <div class="card-name">${data[JPA_list[i].id].student[0].name}</div>
                        <div class="card-name">JPA : ${JPA_list[i].jpa} </div>
                    </div>
                    `);
                }
                const subjects = Subjects_list[0].table;
                if(subjects){
                    $(".div3").append(`<canvas id="radar-chart" >  </canvas>`);
                    createRadarChart(subjects);
                }
                for(let i = 0 ; i< Subjects_list.length ;i++){

                    $(".users_table").append(`
                        <tr>
                            <td>
                                ${data[Subjects_list[i].id].student[0].name}
                            </td>
                            <td>
                                <button class=" custom-button show_${Subjects_list[i].id}"> مراقبة</button>
                            </td>
                        </tr>
                    `);
                    $(`.show_${Subjects_list[i].id}`).click(()=>{
                        createRadarChart(Subjects_list[i].table);
                    })
                }
            })

            function grab_data(data_item){
                let array_subs =[];
                data_item.second_semester_subjects.forEach((da,ia)=>{
                    array_subs.push({subject : da.subject , notes:[data_item.first_semester_subjects.find(subject => subject.subject === da.subject).total,data_item.second_semester_subjects.find(subject => subject.subject === da.subject).total,data_item.semester_subjects.find(subject => subject.subject === da.subject).total]})
                })
                return array_subs;
            }
            const createRadarChart = (data) => {
            const ctx = document.getElementById("radar-chart").getContext("2d");

            new Chart(ctx, {
                type: "radar",
                data: {
                labels: data.map(subject => subject.subject),
                datasets: data.map(subject => ({
                    label: `Notes Progress - ${subject.subject}`,
                    data: subject.notes,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                })),
                },
            });
            };




        </script>
    @endpush


    </section>


    <!-- ========================= Search barre ==================== -->





@endsection
