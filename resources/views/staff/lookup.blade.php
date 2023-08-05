<?php
declare(strict_types=1);
?>
@extends('template_empty')




@section('content')
    {{-- <h2 class="" style="margin-left: 40px; font-size: 30px; text-align: center; margin-top: 10px;  ">بريدي واصل</h2> --}}


    <!--Ajouter des heurs sur l'emploi-->
    <section id="addHours" style="text-align: center;
    width: 100vw;
    height: 100vh;
    display: grid;
    align-items: center;
    justify-content: center;">
           <img src="{{ asset('assets/img/lookup.svg')}}" class="image" alt="" style=" width: 26rem; margin: auto; margin-top: 20px; margin-bottom: -13rem;" />
{{-- border: 2px solid  #185327; --}}
        <div style=" width: 90% ; margin-left: 60px; border-radius: 20px; marging-top: 20px; ">
            @csrf
            <div class="parent" style="width: 80vw;">
                <div class="card card2" style="grid-area: 1 / 1 / 3 / 9; height: 18vh;">
                    <input type="search" placeholder="رقم الهوية" class="btn-dark query" style="    width: -webkit-fill-available ;     background-color: #d3fbd7; border-color: #188f0e; color: #000; "   />
                    <button class="btn-dark search" style="width: 9%;margin-top: 3rem;">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>

            </div>
        </div>

    </section>


    <!-- ========================= Search barre ==================== -->





@endsection
@push('scripts')
<script>
    $(()=>{
        $(".search").click(()=>{
            let text = $(".query").val();

            const encodedValue = encodeURIComponent(text);

            // Build the URL with the query parameter
            const redirectURL = '/result?q=' + encodedValue;

            // Redirect to the URL
            window.location.href = redirectURL;
        })
    })
</script>
@endpush