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
            var api = JSON.parse(`{!! json_encode($api, JSON_HEX_TAG) !!}`);

            console.log("user");
            console.log(user);

        })
    </script>

    <li>
        <a href="/app/home">
            <span class="icon">
                <ion-icon name="home-outline"></ion-icon>
            </span>
            <span class="title">home</span>
        </a>
    </li>


    <li class="hovered">
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


@section('content')
    <h2 class="" style="margin-left: 40px; font-size: 30px;">بريدي واصل</h2>


    <!--Ajouter des heurs sur l'emploi-->
    <section id="addHours" style="text-align: center;">
{{-- border: 2px solid  #185327; --}}
        <div style=" width: 90% ; margin-left: 60px; border-radius: 20px; marging-top: 20px; ">
            @csrf
            <div class="parent">
                <div class="card card1">
                    <label class='std-count'> 0 عدد طلاب</label>
                    <button class="btn-dark upload-students">
                        <ion-icon name="cloud-upload"></ion-icon>
                        رفع قاعدة بيانات الطالب
                    </button>
                </div>
                <div class="card card2">
                    <label class='sheet-count'> 0 عدد نتائج </label>
                    <button class="btn-dark upload-sheets">
                        <ion-icon name="list"></ion-icon>
                        رفع قاعدة بيانات النتائج
                    </button>
                </div>
                <div class="card card3">
                    <label>  غير نشط </label>
                    <button class="btn-dark whats-link">
                        <ion-icon name="chatbubbles"></ion-icon>
                        ربط الواتساب
                    </button>
                </div>
            </div>
        </div>

    </section>
    <section style="width: 100%;height: 54vh; display:grid ; justify-items: center; align-items: center;margin-top: 22px;">
        {{-- <div class="card-neu"> --}}
                <!--=======================users==================-->
    <div class="table" style="width: 90%;  ">

        <div class="headeer">
            <span style="width: 25%;">اسم</span>
            <span style="width: 20%;">رقم تعريف</span>
            <span style="width: 20%;">الفصل</span>
            <span style="width: 20%;">رقم الصف</span>
            <span style="width: 20%;">الجوال</span>
            <span style="width: 12%;">رسالة </span>
            <span style="width: 15%;">حالة</span>
        </div>

        <div class="bodyy" style="border: none;">
            <div class="tableau">

                <div class="info">
                    <span style="width: 25%;">Soulaiman</span>
                    <span style="width: 20%;">1231212</span>
                    <span style="width: 20%;">AE6</span>
                    <span style="width: 20%;">B</span>
                    <span style="width: 20%;">0622946401</span>
                    <span style="width: 12% ">
                        <button value="SEND" class="btnReponde">
                            <ion-icon name="send-outline"></ion-icon>
                        </button>
                    </span>
                    <span style="width: 15% ">
                        <a href="" class="btnReponde">
                            <ion-icon name="send-outline"></ion-icon>
                        </a>
                    </span>

                </div>
            </div>

            {{-- <input type="button" id="Validbtn" disabled
                style="margin: 30px; margin-left: 55px; width: 200px; height: 50px; color: #f5f5f5; background-color: #185327; border-radius: 20px; text-align: center; "
                value="ارسال"> --}}


        </div>

    {{-- </div> --}}
    <input type="file" accept=".xlx,.xlsx,.xls" id="file-students" class="students-val" hidden style="display: none;">
    <input type="file" accept=".xlx,.xlsx,.xls" id="file-sheets" class="sheets-val" hidden style="display: none;">
        </div>

@push('scripts')
<script>
    const url = window.location.origin;
    var ids = {};
    // var students_list = {};
    var sheets_list = {};
    const user = JSON.parse(`{!! json_encode($user, JSON_HEX_TAG) !!}`);
    const api = JSON.parse(`{!! json_encode($api, JSON_HEX_TAG) !!}`);
    $(()=>{
        console.log(api)
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $(".upload-sheets").click(()=>{
            if(ids.length > 0){
            $(".sheets-val").trigger("click");
            }else{
                Swal.fire({
                    icon: 'error',
                    title: '',
                    text: 'المرجو ادخال لائحة طلاب اولا',
                })
            }
        })

        $(".sheets-val").change(()=>{
            const file = document.getElementById('file-sheets').files[0];
            // Create a FormData object to send the file to the API
            const formData = new FormData();
            formData.append('file', file);

            // Make the AJAX request and handle the response as a Blob using the promise function
            makeRequest(url, formData , csrfToken)
            .then((blob) => {
                // Create a Blob URL for the received data
                const url = URL.createObjectURL(blob);

                // Create a temporary link element to initiate the download
                const link = document.createElement('a');
                link.href = url;
                link.download = 'list.xlsx';

                // Append the link to the document, click it, and then remove it
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Clean up the Blob URL to release resources
                URL.revokeObjectURL(url);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
            const reader = new FileReader();

            reader.onload = function (e) {
            const fileData = new Uint8Array(e.target.result);
            const workbook = XLSX.read(fileData, { type: 'array' });

            const extractedData = [];

            workbook.SheetNames.forEach((sheetName) => {
                const sheet = workbook.Sheets[sheetName];
                const cellQ30 = sheet['Q30'];
                const cellB9 = sheet['B9'];
                const cellAJ11 = sheet['AJ11'];
                const cellD17 = sheet['D17'];
                const cellF15 = sheet['F15'];
                const cellI19 = sheet['I19'];
                const cellE20 = sheet['E20'];
                const cellM21 = sheet['M21'];
                const cellAB21 = sheet['AB21'];
                const cellR23 = sheet['R23'];
                const cellAD23 = sheet['AD23'];
                const cellD26 = sheet['D26'];
                const cellAA26 = sheet['AA26'];
                const cellD28 = sheet['D28'];
                const cellAF28 = sheet['AF28'];
                const cellY28 = sheet['Y28'];
                const cellK29 = sheet['K29'];
                const cellU29 = sheet['U29'];
                const cellAA29 = sheet['AA29'];
                const cellAM29 = sheet['AM29'];
                const cellG51 = sheet['G51'];
                const cellG52 = sheet['G52'];
                const cellH54 = sheet['H54'];
                const cellH55 = sheet['H55'];

                // Extract data from cell Q30 and D28
                const id_number = cellQ30 && cellQ30.v ? cellQ30.v.toString() : '';
                const state = cellB9 && cellB9.v ? cellB9.v.toString() : '';
                const state_ar = cellAJ11 && cellAJ11.v ? cellAJ11.v.toString() : '';
                const title1 = cellD17 && cellD17.v ? cellD17.v.toString() : '';
                const title1_ar = cellF15 && cellF15.v ? cellF15.v.toString() : '';
                const title2 = cellI19 && cellI19.v ? cellI19.v.toString() : '';
                const title2_ar = cellE20 && cellE20.v ? cellE20.v.toString() : '';
                const title3 = cellM21 && cellM21.v ? cellM21.v.toString() : '';
                const title3_ar = cellAB21 && cellAB21.v ? cellAB21.v.toString() : '';
                const year = cellR23 && cellR23.v ? cellR23.v.toString() : '';
                const year_ar = cellAD23 && cellAD23.v ? cellAD23.v.toString() : '';
                const school = cellD26 && cellD26.v ? cellD26.v.toString() : '';
                const school_ar = cellAA26 && cellAA26.v ? cellAA26.v.toString() : '';
                const name = cellD28 && cellD28.v ? cellD28.v.toString() : '';
                const name_ar = cellAF28 && cellAF28.v ? cellAF28.v.toString() : '';
                const class_val = cellY28 && cellY28.v ? cellY28.v.toString() : '';
                const nationality = cellU29 && cellU29.v ? cellU29.v.toString() : '';
                const nationality_ar = cellAA29 && cellAA29.v ? cellAA29.v.toString() : '';
                const birth_day = cellK29 && cellK29.v ? cellK29.v.toString() : '';
                const birth_day_ar = cellAM29 && cellAM29.v ? cellAM29.v.toString() : '';
                const sort_by_grade = cellG51 && cellG51.v ? cellG51.v.toString() : '';
                const sort_by_class = cellG52 && cellG52.v ? cellG52.v.toString() : '';
                const absence = cellH54 && cellH54.v ? cellH54.v.toString() : '';
                const latency = cellH55 && cellH55.v ? cellH55.v.toString() : '';

                // Extract table data starting from P36
                const startingCell = 'P36';
                const columnHeaders = [
                {name :'subject' , cell:0},
                {name :'grade' , cell:7},
                {name :'Totale' , cell:15},
                {name :'end_period' , cell:17},
                {name :'Evaluation' , cell:19},
                {name :'Short_test' , cell:24},
                {name :'subject_ar' , cell:26},
                    ];
                const { r: startingRow, c: startingColumn } = XLSX.utils.decode_cell(startingCell);
                const tableData = [];

                for (let row = startingRow; ; row++) {
                const rowData = {};
                let allCellsEmpty = true;

                columnHeaders.forEach((header, index) => {
                    const cellValue = sheet[XLSX.utils.encode_cell({ r: row, c: startingColumn + header.cell })]?.v;
                    rowData[header.name] = cellValue || '';
                    if (cellValue) {
                    allCellsEmpty = false;
                    }
                });

                if (allCellsEmpty) {
                    break;
                }

                tableData.push(rowData);
                }

                // Create the final object with name, id, and table data
                const object = {
                    id_number,
                    state,
                    state_ar,
                    title1,
                    title1_ar,
                    title2,
                    title2_ar,
                    title3,
                    title3_ar,
                    year,
                    year_ar,
                    school,
                    school_ar,
                    name,
                    name_ar,
                    'class' : class_val,
                    nationality,
                    nationality_ar,
                    birth_day,
                    birth_day_ar,
                    sort_by_grade,
                    sort_by_class,
                    absence,
                    latency,
                    table: tableData };
                extractedData.push(object);
            });

            //   console.log(extractedData);
            extractedData.forEach((item) => {
            item.table = JSON.stringify(item.table);
            });
            console.log(extractedData);
            // You can now use the 'extractedData' array of objects as required.
            //   sheets_list = extractedData;
            uploadsheets(url, extractedData)
            .then((res)=>{
                console.log(res);
                const data = res;
                $(".sheet-count").text(` ${data.length} عدد نتائج`)
                if(sheets_list.length > 0){
                    sheets_list = [...sheets_list , ...res];
                }else{
                    sheets_list = res;
                }
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    $(`.status-${element.id_number}`).empty()
                    $(`.status-${element.id_number}`).append(`
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                    `)
                }
                if(res.length >0 ){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'تم الحفض',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }

            })
            .catch((errorMessage)=>{
                console.error(errorMessage);
            });

        }



        reader.readAsArrayBuffer(file);
        });
        $(".upload-students").click(()=>{
            $(".students-val").trigger("click");
        })
        $(".students-val").change(()=>{


            file = document.getElementById('file-students').files[0];
            if (file === undefined) {
                alert('Please select an Excel sheet');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                // Assuming you have the Excel file stored in a variable called 'workbook'
                const sheetName = workbook.SheetNames[1]; // Assuming the second sheet is the target sheet
                const sheet = workbook.Sheets[sheetName];
                const range = XLSX.utils.decode_range(sheet['!ref']); // Get the range of cells in the sheet

                const tableData = [];

                // Iterate over the rows in the range, starting from the 5th row (index 4)
                for (let row = range.s.r + 5; row <= range.e.r; row++) {
                    const cellB = sheet['B' + row]?.v || '';
                    const cellC = sheet['C' + row]?.v || '';
                    const cellD = sheet['D' + row]?.v || '';
                    const cellE = sheet['E' + row]?.v || '';
                    const cellF = sheet['F' + row]?.v || '';

                    const rowData = {
                    phone: cellB,
                    class_number: cellC,
                    class: cellD,
                    name: cellE,
                    id_number: cellF
                    };

                    tableData.push(rowData);
                }
                // const data = XLSX.utils.sheet_to_json(sheet, { header: 1 });
                // const mindata = data.splice(0, 4);
                console.log(tableData);
                $(".std-count").text(` ${tableData.length} عدد طلاب`)
                const jsn_data =  JSON.stringify(tableData);
                console.log(jsn_data)
                uploadstudents(url, jsn_data, csrfToken)
                .then((res)=>{
                    console.log(res);
                    const data2 = res;
                    ids = res;
                    for (let i = 0; i < data2.length; i++) {
                        const element = data2[i];
                        $(`.status-${element.id_number}`).empty()
                        $(`.status-${element.id_number}`).append(`
                            <ion-icon name="cloud-done"></ion-icon>
                        `)
                    }
                    if(res.length >0 ){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'تم الحفض',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }


                })
                .catch((errorMessage)=>{
                    console.error(errorMessage);
                });


                // 45231
                $(".tableau").empty();
                tableData.forEach((student)=>{
                    if(student.id_number){
                        $(".tableau").append(`
                            <div class="info info-${student.id_number}">
                                <span style="width: 25%;">${student.name}</span>
                                <span style="width: 20%;">${student.id_number}</span>
                                <span style="width: 20%;">${student.class   }</span>
                                <span style="width: 20%;">${student.class_number}</span>
                                <span style="width: 20%;">${student.phone}</span>
                                <span style="width: 12% ">
                                    <button value="SEND" class="btnReponde link-${student.id_number}">
                                        <ion-icon name="hourglass"></ion-icon>
                                    </button>
                                </span>
                                <span style="width: 15% ">
                                    <a href="" class="btnReponde status-${student.id_number}">
                                        <ion-icon name="close-circle-outline"></ion-icon>
                                    </a>
                                </span>

                            </div>
                        `);
                    }

                });
            };
            reader.readAsArrayBuffer(file);
        });
    });

    function uploadstudents(url, data) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: `${url}/api/addstudents`,
                method: 'POST',
                data: $.param({ data: data , id : user.id }),
                headers: {
                    'X-CSRF-TOKEN': user.token_api,
                    'Content-Type': 'application/x-www-form-urlencoded',
                    // 'Cookie': document.cookie,
                },
                processData: false,
                contentType: false,
                success: (response)=>{
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject('Error : ' + xhr.status + ' ' + error);
                }
            });
        });
    }

    function uploadsheets(url, data) {
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: `${url}/api/addsheets`,
      method: 'POST',
      data: JSON.stringify({ data: data, id: user.id }),
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

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function makeRequest(url, formData , csrfToken) {
    return new Promise(function (resolve, reject) {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', `${url}/api/update-sheet`, true);
      xhr.setRequestHeader('X-CSRF-TOKEN', user.token_api); // Replace 'your-csrf-token' with the actual CSRF token
      xhr.responseType = 'blob';
      xhr.onload = function () {
        if (xhr.status === 200) {
          resolve(xhr.response);
        } else {
          reject(new Error('Request failed with status ' + xhr.status));
        }
      };

      xhr.onerror = function () {
        reject(new Error('Request failed'));
      };

      xhr.send(formData);
    });
  }
    </script>
@endpush


    </section>


    <!-- ========================= Search barre ==================== -->





@endsection
