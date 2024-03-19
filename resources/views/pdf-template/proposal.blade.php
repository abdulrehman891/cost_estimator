<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}"> --}}
    {{-- {{ file_get_contents(asset('assets/css/style.bundle.css')) }} --}}


    <style>
        {{ file_get_contents(public_path('css/pdf-style.css')) }}
    </style>

</head>

<body class="body">
<header>

    <div class="container-fluid d-flex flex-column align-items-start bimage2"
         style="background-image:url('assets/image/forntDesign.png')">
        {{--            <img style="height: 200px;" src="{{ public_path('assets/media/image/logo.jpg') }}" class="img-thumbnail  logo" --}}
        <img style="height: 200px;" src="{{ public_path('storage/' . $company_logo) }}" class="img-thumbnail  logo"
             alt="Logo Image not Found">

        <div class="container d-flex flex-column align-items-end twin">
            <div class="card  border-0 ">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold  fs-1 txt">{{ $project_name }}</h5>
                    <p class="card-text fs-4">{{ $project_address }}</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Section-one -->
<section id="section_1">
    <div class="container" style="">
        <img src="{{ public_path('storage/' . $project_image) }}" style="max-width: 100%; height: auto;"
             alt="Project Image not found">
        <div class="project_txt m-0">
            <b> Prepared By:</b> {{ $company_name }}
        </div>
        <div class="project_txt m-0 text-black">
            <span> <b> Prepared Date:</b> {{ $prepared_date }}</span><br />
            <span> <b> Project Manager:</b> {{ $project_manager }}</span>
        </div>
    </div>
</section>

<!-- section-two -->


<div class="container-fluid bimage4"
     style="background-image:url('assets/image/blueCorner.png'); page-break-before: always;">
    <div class="container inclusion" style="">
        <h2 class="d-flex align-left text-start txt">Inclusions:</h2>
        <p class="d-flex text-start  ">{{ $inclusion }}</p>
    </div>
</div>

<!-- section-three -->

 <h2 class="container d-flex align-left  text-start mt-2">Steps of Project Completion:</h2>


<div class="container mt-2 d-flex text-start">


    <ul>
        {!! nl2br($steps_of_work) !!}
    </ul>
</div>
<h2 class="container d-flex align-left  text-start mt-2">60 Mil TPO (Mule-Hide):</h2>
<div class="container mt-2 d-flex text-start">


    <ul>
        {!! nl2br($mil_tpo) !!}
    </ul>
</div>

<!-- section-four-->
<div class="container-fluid  bimage3"
     style="background-image:url('assets/image/twoStrips.png');page-break-before: always;">
    <div class=" container mt-2 text-start">
        <div>
            <h2 class="txt">Exclusions:</h2>
        </div>

        {!! nl2br($exclusions) !!}

        <br />
         <div >
         <h2 class="txt">Validity:</h2>
        </div>

        {!! nl2br($validity) !!}
        <br />


        <div >
            <h2 class="txt">Disclaimer:</h2>
        </div>

        {!! nl2br($disclaimer) !!}
        <br />

        <div >
            <h2 class="txt">Risk Factor:</h2>
        </div>

        {!! nl2br($risk_factor) !!}
        <br />


{{--        {!! nl2br($chatGPTResponse) !!}--}}


         <h2 class="mt-4 txt">List of Products:</h2>
        <ul>
            {!! nl2br($required_list_products) !!}
        </ul>

        <h2 class="mt-4 txt">Lead Times:</h2>
        <p>Expected lead time at the time of bidding is 2 - 3 weeks.</p>

        <h2 class="mt-4 txt">Project Milestones:</h2>
        <ul>
            {!! nl2br($milestones) !!}
        </ul>
        <h2 class="mt-4 txt">Total Cost:</h2>
        {!! nl2br($total_cost) !!}

        @foreach ($mileStoneData as $milestone)
            <p><strong><u>{{ $milestone['milestone_name'] }}:</u></strong> {{ $milestone['milestone_description']  }} </p>
            <p>Total: {{ $milestone['milestone_cost'] }} </p>
        @endforeach
        </div>
        </div>
    </div>
</div>
<!-- section-five-->

<div class="container text-start payment" style="page-break-before: always; height: 90%; margin-top: 50px;">
    {{--        <h5 class="txt">Total: $659,750.00</h5> --}}

    <h5 class="mt-4 txt">Payment Schedule:</h5>
    <p>{{ $payment_schedule }}</p>

    <h5 class="mt-4 txt">Price Escalation Clause:</h5>
    <p>{{ $price_escalation_clause }}</p>

    <h5 class="mt-4 txt">Alterations:</h5>
    <p>{{ $alterations }} </p>
    <h5 class="mt-4 txt">Compliance:</h5>
    <p>{{ $compliance }} </p>

    <h5 class="mt-4 txt">Timeline:</h5>
    <p>{{ $timeline }} </p>

    <h5 class="mt-4 txt">Warranty:</h5>
    <p>{{ $warranty_clause }}</p>
    <div class="row">
        <div class="col-12">
            <div class="col-4" style="width: 33.33%; float:left;"></div>
            <div class="col-4" style="width: 33.33%; float:left;"></div>
            <div class=" col-4" style="width: 33.33%; float:left;">
                <h5 class="mt-4 text-start">Contract Bid Accepted By:</h5>
                <p>Name: ______________________________</p>
                <p>Title: _______________________________</p>
                <p>Signature: ___________________________</p>
                <p>Date: _______________________________</p>
            </div>
        </div>
    </div>

</div>

<footer>
    <div class="container text-start mt-2">
        <p><span>{{ $company_address }}</span> | <span>PH: {{ $company_phone }}</span> |
            <span>{{ $company_email }}</span>
        </p>
        <p><span><strong>{{ $company_website }}</strong></span> |
            <span><strong>{{ $company_name }}</strong></span>
        </p>
    </div>
</footer>
</body>

</html>
