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
    {{-- <link rel="stylesheet" href="{{asset('css/style.css')}}"> --}}
    <style>
        {{ file_get_contents(public_path('css/pdf-style.css')) }}
    </style>

</head>

<body class="body">

    <header>

        <div class="container-fluid mt-2 d-flex flex-column align-items-start">
{{--            <img style="height: 200px;" src="{{ public_path('assets/media/image/11.jpg') }}" class="img-thumbnail  logo"--}}
            <img style="height: 200px;" src="{{ public_path('storage/'.$company_logo) }}" class="img-thumbnail  logo"
                alt="Logo Image not Found">

        </div>
        <div class="bimage2">
{{--            src="{{ public_path('storage/'.$project_image) }}"--}}
            <img class="bimage2" width="2000px" height="auto" src="{{ public_path('assets/media/image/66.png') }}"  alt="66 not found">

        </div>

        <div class="container  mt-5 d-flex flex-column align-items-end">
            <div class="card  border-0 ">
                <div class="card-body text-center twin">
                    <h5 class="card-title fw-bold  fs-1 txt">{{ $project_name }}</h5>
                    <p class="card-text fs-4">{{ $project_address }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Section-one -->
    <section id="section_1">
        <div class="container" style=" margin-top: 300px;">
            <img  src="{{ public_path('storage/'.$project_image) }}" style="max-width: 100%; height: auto;"
                alt="Project Image not found">
            <div class="upper-text m-0">
                Prepared By: {{ $company_name }}
            </div>
            <div class="lower-text m-0 text-black">
                <span>Prepared Date: {{ $prepared_date }}</span><br />
                <span>Project Manager: {{ $project_manager }}</span>
            </div>
        </div>
    </section>

    <!-- section-two -->
    <div class="bimage4" style="  background-image:url('assets/image/88.png') ">
        <div class="container section_2 mt-5 " style="page-break-before: always ">
            <h2 class="d-flex align-left txt">Inclusions:</h2>
            <p class="d-flex text-start  ">{{ $inclusion }}</p>
        </div>
    </div>
    <!-- section-three -->

    <h2 class="container d-flex align-left  text-start mt-2">30-Year Architectural Shingles (Certainteed
        Landmark):</h2>


    <div class="container mt-2 d-flex text-start">


        <ul>
            {!! nl2br($year_architect_shingles) !!}
        </ul>
    </div>
    <h2 class="container d-flex align-left  text-start mt-2">60 Mil TPO (Mule-Hide):</h2>
    <div class="container mt-2 d-flex text-start">


        <ul>
            {!! nl2br($mil_tpo) !!}
        </ul>
    </div>
    <!-- section-four-->
    <div class="  container mt-2 text-start">
        <div class="bimage3" style=" background-image:url('assets/image/77.png') ">
            <div >
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


{{--            {!! nl2br($chatGPTResponse) !!}--}}

            <h2 class="mt-4 txt">Lead Times:</h2>
            <p>Expected lead time at the time of bidding is 2 - 3 weeks.</p>

            @foreach($mileStoneData as $milestone)
                <p><strong><u>{{ $milestone['milestone_name'] }}:</u></strong> {{ $milestone['milestone_description']  }} </p>
                <p>Total: {{ $milestone['milestone_cost'] }} </p>
            @endforeach
        </div>
    </div>
    <!-- section-five-->
    <div class="container mt-2 text-start">
{{--        <h5 class="txt">Total: $659,750.00</h5>--}}

        <h5 class="mt-4 txt">Payment Schedule:</h5>
        <p>{{ $payment_schedule }}</p>
        <div class="bimage" style="background-image:url('assets/image/55.png') ">
            <h5 class="mt-4 txt">Price Escalation Clause:</h5>
            <p>{{ $price_escalation_clause }}</p>

            <h5 class="mt-4 txt">Alterations:</h5>
            <p>{{ $alterations }} </p>
            <h5 class="mt-4 txt">Compliance:</h5>
            <p>{{ $compliance }} </p>

            <h5 class="mt-4 txt">Timeline:</h5>
            <p>{{ $timeline }} </p>
        </div>
        <h5 class="mt-4 txt">Warranty:</h5>
        <p>{{ $warranty_clause }}</p>
        <div class="d-flex flex-column align-items-end">
            <h5 class="mt-4">Contract Bid Accepted By:</h5>
            <p>Name: ______________________________</p>
            <p>Title: _______________________________</p>
            <p>Signature: ___________________________</p>
            <p>Date: _______________________________</p>
        </div>


    </div>

    <footer>
        <div class="container text-start mt-2">
            <p><span>{{ $company_address }}</span> | <span>PH: {{ $company_phone }}</span> |
                <span>{{ $company_email }}</span>
            </p>
            <p><span><strong>{{ $company_website }}</strong></span> | <span><strong>{{ $company_name }}</strong></span></p>
        </div>
    </footer>
</body>

</html>
