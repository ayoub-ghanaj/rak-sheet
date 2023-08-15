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
    grid-column-gap: 12px;
    grid-row-gap: 13px;
    height:100vh;
    }

    .div1 {  grid-area: 1 / 4 / 2 / 5; }
    /* .div2 { grid-area: 1 / 2 / 2 / 3; } */
    .div3 { grid-area: 1 / 3 / 2 / 4; }
    .div4 { grid-area: 1 / 1 / 2 / 2; }
    .div5 { grid-area: 2 / 1 / 5 / 5;
            background-color: #f8f8f8; /* Light gray background */
            padding: 20px; /* Add some padding around the content */
            border: 1px solid #ccc; /* Add a border to further separate it from the background */
            border-radius: 8px; /* Add some border radius to make it look more rounded */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow to give it depth*/
            height: max-content;
          }
    .div6 { grid-area: 1 / 2 / 2 / 3; }
    .div7 { grid-area: 1 / 5 / 9 / 6;
      max-height: 100vh; /* Set a fixed height as per your requirement */
      overflow-y: auto;
      border: #cecece 1px solid;
      border-radius: 12px;
    }
    .div8 { grid-area: 6 / 1 / 9 / 5;
            background-color: #f8f8f8; /* Light gray background */
            padding: 20px; /* Add some padding around the content */
            border: 1px solid #ccc; /* Add a border to further separate it from the background */
            border-radius: 8px; /* Add some border radius to make it look more rounded */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow to give it depth*/
            height: max-content;
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
            @media screen and (min-width: 1432px) {
              .div2 {
                display: inherit !important;
                /* Styles for screens wider than 1431 pixels */
                /* Add your custom styles here that you want to apply only for wider screens */
              }
              .div1 { grid-area: 1 / 3 / 2 / 4; }
              .div2 { grid-area: 1 / 2 / 2 / 3; }
              .div3 { grid-area: 1 / 4 / 2 / 5; }
              .div4 { grid-area: 1 / 1 / 2 / 2; }
              .div5 { grid-area: 2 / 1 / 5 / 5; }
              .div6 { grid-area: 1 / 1 / 2 / 2;  }
              .div7 { grid-area: 1 / 5 / 9 / 6; }
              .div8 { grid-area: 6 / 1 / 9 / 5; }
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
.swal2-modal{
            width :80vw !important;
        }
    </style>
    <div class="parent">
      <div class="div1 count-succ">
        <div class="card">
          <div class="small-title">عدد طلاب</div>
          <div class="value all-count-val-succ"></div>
          <div class="main-title">المتفوقين</div>
        </div>
      </div>
      <div class="div2 count-nata" style="display : none;" >
        <div class="card">
          <div class="small-title">عدد النتائج</div>
          <div class="value all-count-sheet"></div>
        </div>
      </div>
      <div class="div3 count-suck">
        <div class="card">
          <div class="small-title">عدد طلاب</div>
          <div class="value all-count-val-suck"></div>
          <div class="main-title">الضعاف</div>
        </div>
      </div>
      <div class="div4 bg"> </div>
      <div class="div5 succ">
        <h4> لائحة الطلبة المتفوقين </h4>
        <div class="card-scroll-container">
          <div class="card-container succ-cards">
            <!-- Cards will be dynamically added here -->
          </div>
        </div>
      </div>
      <div class="div6 count-all">
        <div class="card">
          <div class="small-title">عدد طلاب</div>
          <div class="value all-count-val"></div>
          <div class="main-title">المجموع</div>
        </div>
       </div>
      <div class="div7 right">
        <h3> لائحة الطلاب <h3>
        <table style="width: 100%; margin-top : 20px;"  border="1">
         <thead>
           <tr>
             <td>name</td>
             <td>id</td>
             <td>search</td>
            <tr>
          </thead>
          <tbody class="all-students">

          </tbody>
        </table>
      </div>
      <div class="div8 loose">
        <h4> لائحة الطلبة غير المفوقين </h4>
        <div class="card-scroll-container">
          <div class="card-container suck-cards">
            <!-- Cards will be dynamically added here -->
          </div>
        </div>
      </div>
      </div>
    @push('scripts')
        <script>
            const url = window.location.origin;
            const data = {!! json_encode($data) !!};
            const user = JSON.parse(`{!! json_encode($user, JSON_HEX_TAG) !!}`);
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
              console.log(data);
              $(".all-count-val").text(data[1].length)
              $(".all-count-sheet").text(data[0][0].count_sheet)
              $(".all-count-val-succ").text(data[2].length)
              $(".all-count-val-suck").text(data[3].length)
              data[1].forEach((item, index)=>{
                $(".all-students").append(`
                <tr>
                  <td>${item.name}</td>
                  <td>${item.id_number}</td>
                  <td><a href="/result?q=${item.id_number}"> <button class="custom-button" >search<button> </a></td>
                <tr>
                `)
              })
              data[2].forEach((item, index)=>{
                $(".succ-cards").append(`
                <div class="card">
                  <div class="card-id">عدد مواد :${ JSON.parse(item.table).length}</div>
                  <div class="card-name">${item.id_number}</div>
                  <button class="card-button check-${item.id_number}">مراجعة</button>
                </div>
                `)
                $(`.check-${item.id_number}`).click(()=>{
                  // alert(item.sheet_id);
                  uploadsheets(url, item.id).then((res)=>{
                    console.log(res[0].table);
                    // console.log(JSON.parse(res[0].table));
                    const data_api = JSON.parse(res[0].table);
                    console.log(data_api);
                    Swal.fire({
                      // title: 'Table with Conditional Styling',
                      html: createTable(data_api),
                      showCloseButton: true,
                      showConfirmButton: false
                    });
                  })
                })
              })
              data[3].forEach((item, index)=>{
                $(".suck-cards").append(`
                <div class="card">
                  <div class="card-id">عدد مواد :${JSON.parse(item.table).length}</div>
                  <div class="card-name">${item.id_number}</div>
                  <button class="card-button check-${item.id_number}">مراجعة</button>
                </div>
                `)
                $(`.check-${item.id_number}`).click(()=>{
                  uploadsheets(url, item.id).then((res)=>{
                    console.log(res[0].table);
                    // console.log(JSON.parse(res[0].table));
                    const data_api = JSON.parse(res[0].table);
                    console.log(data_api);
                    Swal.fire({
                      // title: 'Table with Conditional Styling',
                      html: createTable(data_api),
                      showCloseButton: true,
                      showConfirmButton: false
                    });
                  })
                })
              })
            })

        function uploadsheets(url, id) {
          return new Promise(function(resolve, reject) {
            $.ajax({
              url: `${url}/api/gettable`,
              method: 'POST',
              data: JSON.stringify({ id: id}),
              headers: {
                'X-CSRF-TOKEN': user.token_api,
                'Content-Type': 'application/json', // Set Content-Type to application/json
              },
              success: (response) => {
                resolve(response);
              },
              error: function(xhr, status, error) {
                reject('Error: ' + xhr.status + ' ' + error);
              }
            });
          });
        }

        function createTable(dataArray) {
          const table = document.createElement("table");

          const headerRow = document.createElement("tr");
          const headerTitles = ["Subject", "Grade", "Total", "End Period", "Evaluation", "Short Test", "Subject (Arabic)"];
          headerTitles.forEach(title => {
            const th = document.createElement("th");
            th.textContent = title;
            headerRow.appendChild(th);
          });
          table.appendChild(headerRow);

          dataArray.forEach(data => {
            const row = document.createElement("tr");

            const keys = Object.keys(data);
            keys.forEach(key => {
              const cell = document.createElement("td");
              cell.textContent = data[key];
              row.appendChild(cell);
            });

            // Apply conditional styles based on the Totale value
            const totalCell = row.querySelector("td:nth-child(3)");
            const totalValue = parseFloat(totalCell.textContent);
            // if (totalValue <= 50) {
            //   totalCell.style.backgroundColor = "red";
            //   totalCell.style.color = "white";
            // } else {
            //   totalCell.style.backgroundColor = "green";
            //   totalCell.style.color = "white";
            // }

            table.appendChild(row);
          });

          return table.outerHTML;
        }

        // Show the Swal2 popup with the table content
        </script>
    @endpush


    </section>


    <!-- ========================= Search barre ==================== -->





@endsection
