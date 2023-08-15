<?php
declare(strict_types=1);
?>
@extends('template')


@section('img')
<img src="{{asset('assets/img/logo.png')}}" class="logo"/>
@endsection
@section('list')



    <li>
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
    <li class="hovered">
        <a href="/app/subjects">
            <span class="icon">
                <ion-icon name="bookmarks-outline"></ion-icon>
            </span>
            <span class="title">المواد التقويمية </span>
        </a>
    </li>
    @endif
    <li>
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


@section('content')
    <h2 class="" style="margin-left: 40px; font-size: 30px;">بريدي واصل</h2>

    <style>
        /* Styling for index page */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #ffffff;
            
        }

        .btn-primary {
            background-color: #007bff;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        /* Styling for create and edit pages */
        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-success {
            background-color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-right {
            text-align: right;
        }
        .button-container {
            display: grid; /* Use grid container */
            grid-template-columns: repeat(2, auto); /* Create two equally sized columns */
            gap: 5px; /* Add some space between buttons */
        }



        /* Optional: Adjust the margin between the buttons */
    
    </style>
    <div class="" style="margin-top:20px;">
        <div class="container" style="text-align: center;">
            <a href="{{ route('low_subjects.create') }}" class="btn btn-success mb-2">اضافة مادة</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>اسم مادة</th>
                        <th>اعدادات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lowSubjects as $lowSubject)
                    <tr>
                        <td>{{ $lowSubject->name }}</td>
                        <td>
                            <div class="button-container">
                                <a href="{{ route('low_subjects.edit', $lowSubject->id) }}" class="btn btn-primary btn-sm" style="text-align:center;">تعديل</a>
                                <form action="{{ route('low_subjects.destroy', $lowSubject->id) }}" method="POST" class="d-inline" style="width: 100%;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="width: inherit;">حذف</button>
                                </form>
                            </div>                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
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
            })
        </script>
    @endpush


    </section>






@endsection
