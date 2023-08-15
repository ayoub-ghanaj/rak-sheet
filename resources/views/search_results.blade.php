<?php
declare(strict_types=1);
?>
@extends('template_empty')
@section('content')
    <style>

        .alert {
            width:100%;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 10px;
            text-align: center;
        }

        .alert-success {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        .alert-danger {
            background-color: #f44336; /* Red */
            color: white;
        }

        .alert-primary {
            background-color: #2196F3; /* Blue */
            color: white;
        }

        .swal2-modal{
            width :80vw !important; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            width: min-content;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Green Background */
        .green-bg {
            background-color: #4b964b; /* or any other shade of green you prefer */
            color: white; /* Set text color to white for better visibility */
        }

        /* Red Background */
        .red-bg {
            background-color: #d54040; /* or any other shade of red you prefer */
            color: white; /* Set text color to white for better visibility */
        }

        /* Blue Background */
        .blue-bg {
            background-color: #75b6cf; /* or any other shade of blue you prefer */
            color: white; /* Set text color to white for better visibility */
        }
    </style>

    <div class="table" style="width: 90%;  ">

        <div class="headeer">
            <span style="width: 25%;">المدير</span>
            <span style="width: 20%;">رقم تعريف</span>
            <span style="width: 10%;"></span>
            <span style="width: 12%;">عنوان</span>
            <span style="width: 8%;">الفصل</span>
            <span style="width: 12%;">رقم الصف</span>
            <span style="width: 20%;">السنة الدراسية</span>
            <span style="width: 15%;"></span>
            <span style="width: 10%;">فتح</span>
        </div>

        <div class="bodyy" style="border: none;">
            <div class="tableau">

            
            </div>

            {{-- <input type="button" id="Validbtn" disabled
                style="margin: 30px; margin-left: 55px; width: 200px; height: 50px; color: #f5f5f5; background-color: #185327; border-radius: 20px; text-align: center; "
                value="ارسال"> --}}


        </div>  
    </div>

@endsection
@push('scripts')
<script>
    $(()=>{
        const url = window.location.origin;
        const data = {!! json_encode($results) !!};
        // console.log(data);
        if(data.length > 0 ){

            $(".tableau").empty();
            data.forEach((item,i)=>{
                
                $(".tableau").append(`
            
                <div class="info">
                        <span style="width: 25%;">${item.teacher}</span>
                        <span style="width: 20%;">${item.id_number}</span>
                        <span style="width: 25%;">${item.title1_ar}</span>
                        <span style="width: 5%;">${item.class_number}</span>
                        <span style="width: 10%;">${item.class}</span>
                        <span style="width: 20%;">${item.year}</span>
                        <span style="width: 27% ">
                            <a  class="btnReponde btnr-${i}">
                                <ion-icon name="open-outline"></ion-icon>
                            </a>
                        </span>
    
                    </div>
                `)
                $(`.btnr-${i}`).click(()=>{
                    get_talble_list(url , item.id).then((res)=>{
                        // console.log(res);
                        let table = "";
                        let jpa_table = '';
                        res.semester_subjects.forEach((ligne , id )=>{
                            if(ligne.subject == "JPA"){
                               jpa_table = `  
                                <table style="width: 100%; margin-top : 20px;"  border="1">
                                        <tr>
                                            <td><b>${ligne.subject}</b></td>
                                            <td> <b> ${ligne.grade} </b></td>
                                            <td class="${(ligne.total>=90)?"green-bg":((ligne.total>=50)?"green-bg":"red-bg")}" >${ligne.total}</td>
                                            <td><b>${ligne.subject_ar}</b></td>
                                        </tr>
                                    </table>
                                `;
                               
                                return; 
                            }
                            if(ligne.rank == "2"){
                                table += `
                                    <tr>
                                        <td><b>${ligne.subject}</b></td>
                                        <td>${ligne.grade}</td>
                                        <td class="${(ligne.total>=54)?"green-bg":((ligne.total>=30)?"blue-bg":"red-bg")}">${ligne.total}</td>
                                        <td>${ligne.end_period}</td>
                                        <td>${ligne.Evaluation}</td>
                                        <td>${ligne.grade_short}</td>
                                        <td><b>${ligne.subject_ar}</b></td>
                                    </tr>
                                    `;
                            }else{

                                table += `
                                    <tr>
                                        <td><b>${ligne.subject}</b></td>
                                        <td>${ligne.grade}</td>
                                        <td class="${(ligne.total>=90)?"green-bg":((ligne.total>=50)?"green-bg":"red-bg")}">${ligne.total}</td>
                                        <td>${ligne.end_period}</td>
                                        <td>${ligne.Evaluation}</td>
                                        <td>${ligne.grade_short}</td>
                                        <td><b>${ligne.subject_ar}</b></td>
                                    </tr>
                                    `;
                                }
                        })
                        Swal.fire({
                            html: `
                            <div id="custom-modal">
                                <div class="alert ${( parseFloat(item.status) >= 90)? 'alert-success': ((parseFloat(item.status) < 50)? 'alert-danger':'alert-primary')}">
                                    <b>
                                        ${item.message}
                                    </b>
                                </div>
    
                            <div style="text-align: center;">
                                <h3>${item.title1_ar}</h3>
                                <h3>${item.title1}</h3>
                                <h4>${item.title2_ar}</h4>
                                <h4>${item.title2}</h4>
                                <div style="display: flex; justify-content: space-evenly;">
                                    <h5>${item.title3_ar}</h5> <h5>${item.title3}</h2>
                                </div>
                                    
                                <div style="display: flex;justify-content: space-evenly;">
                                    <h5>${item.year}</h5> <h5>${item.year_ar}</h5>
                                </div>
                            </div>
        
                            <table style="width: 100%; margin-top : 20px;"  border="1">
                                    <tr>
                                        <td><b>${item.name}</b></td>
                                        <td>${item.class_number}</td>
                                        <td><b>الفصل</b></td>
                                        <td><b>${item.name_ar}</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Date of Birth</b></td>
                                        <td>${item.birth_day}</td>
                                        <td>${item.birth_day_ar}</td>
                                        <td><b>تاريخ الميلاد</b></td>
                                    </tr>
                                    <tr>
                                        <td>${item.class}</td>
                                        <td><b> رقم الفصل</b></td>
                                        <td>${item.nationality_ar}</td>
                                        <td><b> الجنسية</b></td>
                                    </tr>
                            </table>
        
                            <table style="width: 100%; margin-top : 20px;"  border="1">
                                <!-- /Table content goes here -->
                                <thead>
                                    <tr >
                                        <td rowspan=2><b>Subjects</b></td>
                                        <td><b>التقدير</b></td>
                                        <td><b>المجموع</b></td>
                                        <td><b>اختبارات النهاية </b></td>
                                        <td><b>أدوات تقييم </b></td>
                                        <td><b>اختبارات قصيرة</b></td>
                                        <td rowspan=2><b>المواد الدراسية</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Grade</b></td>
                                        <td><b>Total</b></td>
                                        <td><b>Ending tests</b></td>
                                        <td><b>Evaluation tools</b></td>
                                        <td><b>Short tests</b></td>
                                    </tr>
        
                                </thead>
                                <tbody>
                                    ${table}
                                </tbody>
                            </table>
                            ${jpa_table}
                            <table style="width: 100%; margin-top : 20px;"  border="1">
                                <tr>
                                    <td>${item.sort_by_grade}</td>
                                    <td><b>الترتيب على الصف</b></td>
                                    <td>${item.absence}</td>
                                    <td><b>غياب بدون عذر</b></td>
                                </tr>
                                <tr>
                                    <td>${item.sort_by_class}</td>
                                    <td><b>الترتيب على الفصل</b></td>
                                    <td>${item.latency}</td>
                                    <td><b>تأخر بدون عذر </b></td>
                                </tr>
                            </table>
                            </div>
                            `,
                            showConfirmButton: false,
                            showCancelButton: false,
                            allowOutsideClick: true,
                            // customClass: 'custom-modal-class', // Add custom CSS class for styling
                        });
                    })
                })
            })
        }else{
            $(".tableau").empty();
            $(".tableau").append(`
                <h1 style="width:100% ; text-align : center;" >  لا يوجد اي نتيجة</h1>
                <div class="info">
                        <span style="width: 100% ">
                            <a href="/search"  class="btnReponde">
                                <ion-icon name="return-up-back-outline"></ion-icon>
                                العودة
                            </a>
                        </span>
    
                    </div>
                `)
        }
    })
    function get_talble_list(url, id) {
          return new Promise(function(resolve, reject) {
            $.ajax({
              url: `${url}/api/gettablelist`,
              method: 'POST',
              data: JSON.stringify({ id: id}),
              headers: {
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
</script>
@endpush