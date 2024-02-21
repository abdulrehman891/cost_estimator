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
            <img style="height: 200px;" src="{{ public_path('assets/media/image/11.jpg') }}" class="img-thumbnail  logo"
                alt="">

        </div>
        <div class="bimage2">
            <img class="bimage2" width="2000px" height="auto"
            src="{{ public_path('assets/media/image/66.png') }}"  alt="66 not found">

        </div>

        <div class="container  mt-5 d-flex flex-column align-items-end">

            <div class="card  border-0 ">
                <div class="card-body text-center twin">
                    <h5 class="card-title fw-bold  fs-1 txt">{{ $project_name }}</h5>
                    <p class="card-text fs-4">11464 Alamo Ranch, San Antonio, TX 78253</p>
                </div>
            </div>
        </div>
    </header>


    <!-- Section-one -->
    <section id="section_1">
        <div class="container" style=" margin-top: 300px;">
            <img src="{{ public_path('assets/media/image/22.png') }}" style="max-width: 100%; height: auto;"
                alt="22 not found">

            <div class="upper-text m-0">
                Prepared By: LOA Construction, LLC
            </div>
            <div class="lower-text m-0 text-black">
                <span>Prepared Date: {{ $prepared_date }}</span>
                <span>Estimator: Taylor Ivens</span>
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
            <li>Install synthetic underlayment to the entire substrate</li>
            <li>Install 2” X 2” drip edge flashing to all eaves- Color TBD</li>
            <li>Install Ice & water shield to all specified locations</li>
            <li>Install galvanized pipe jack boots as needed</li>
            <li>Paint all penetration pipes with manufacturer recommended paint</li>
            <li>Fabricate and install headwall and sidewall flashing </li>
            <li>Install starter shingles along all eaves and rakes</li>
            <li>Install 30-Year architectural shingles to the field of the roof</li>
            <li>Install corresponding hip and ridge shingles to ridge cap</li>
            <li>Clear and haul off all job-related debris</li>
        </ul>
    </div>
    <h2 class="container d-flex align-start ">60 Mil TPO (Mule-Hide):</h2>
    <div class="container mt-2 d-flex text-start">


        <ul>
            <li>Mechanically Attach ½” Cover Board to substrate (R-Value 2.5)</li>
            <li>Install 60 Mil TPO to field and walls (Fully Adhered)</li>
            <li>Flash Shingle to TPO transition</li>
            <li>Install edge flashing to all eaves- Color TBD</li>
            <li>Install 891 Linear Feet of Termination Bar</li>
            <li>Clear and haul off all job-related debris</li>
        </ul>
    </div>
    <!-- section-four-->
    <div class="  container mt-2 text-start">
        <div class="bimage3" style="  background-image:url('assets/image/77.png') ">
            <div >
                <h2 class="txt">Exclusions:</h2>
            </div>
            {{ $exclusions }}

            {!! nl2br($chatGPTResponse) !!}

{{--            <h2 class="mt-4 txt">Lead Times:</h2>--}}
{{--            <p>Expected lead time at the time of bidding is 2 - 3 weeks.</p>--}}


{{--            <p><strong><u>Building A:</u></strong> Shingle: 340.66 SQ / TPO: 93.74 SQ</p>--}}
{{--            <p>Total: $244,375.00</p>--}}

{{--            <p> <strong><u>Building B:</u></strong> Shingle: 220 SQ / TPO: 59.34 SQ</p>--}}
{{--            <p>Total: $157,835.00</p>--}}

{{--            <p> <strong><u>Building C:</u></strong>Shingle: 236.43 SQ / TPO: 62.07 SQ</p>--}}
{{--            <p>Total: $169,580.00</p>--}}

{{--            <p><strong><u>Maintenance :</u></strong> Shingle: 32.59 SQ</p>--}}
{{--            <p>Total: $23,370.00</p>--}}

{{--            <p><strong><u>Garage (2):</u></strong> Shingle: 20.69 SQ</p>--}}
{{--            <p>Total Per Garage: $14,840.00</p>--}}
{{--            <p>Total: $29,680.00</p>--}}

{{--            <p><strong><u>Gutters:</u></strong>$34,910.00</p>--}}
{{--            <p>1,815 Linear Feet of 5” K- Style Gutters - Aluminum</p>--}}
{{--            <p>3,276 Linear Feet of 2x3 Downspouts</p>--}}

{{--            <p style="color: #cc4125;">--}}
{{--                <strong>SKYTRAK Telehandler:Not included in pricing $7,000.00/month for rental</strong>--}}
{{--            </p>--}}
        </div>
    </div>
    <!-- section-five-->
    <div class="container mt-2 text-start">
{{--        <h5 class="txt">Total: $659,750.00</h5>--}}

        <h5 class="mt-4 txt">Payment Schedule:</h5>
        <p>{{ $payment_schedule }}</p>
        <div class="bimage" style="  background-image:url('assets/image/55.png') ">
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
            <p><span>706 W. Ben White Blvd Suite 233a Austin, TX 78704</span> | <span>PH: 512.645.1687</span> |
                <span>sales@loaconstruction.com</span>
            </p>
            <p><span><strong>www.loaconstruction.com</strong></span> | <span><strong>New Construction
                        Estimate</strong></span></p>
        </div>
    </footer>
</body>

</html>
