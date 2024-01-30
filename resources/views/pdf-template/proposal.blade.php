<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
    ></script>
    <style>
        a{
            text-decoration: none;

        }
        .container {
            text-align: center;
        }

        .upper-text,
        .lower-text {
            text-align: left;
            max-width: 300px; /* Adjust the max-width as needed */
            margin: 0 auto;
        }

        .fs-5 {
            margin: 0; /* Remove default margin from paragraphs */
        }

    </style>
</head>

<body style="height: 500px;">
<header>
    <div class="container mt-2">
        <img style="height: 200px; display: block; margin: 0 auto;" src="img/image004.jpg" class="img-thumbnail" alt="">
    </div>
</header>
<div class="container mt-4">
    <div class="card border-0">
        <div class="card-body text-center">
            <h5 class="card-title fw-bold  fs-1 text-decoration-underline">{{ $project_name }}</h5>
            <p class="card-text fs-4">11464 Alamo Ranch, San Antonio, TX 78253</p>
        </div>
    </div>
</div>
<section id="section_1">
    <div class="container">
        <div class="upper-text fs-5">
            Prepared By: LOA Construction, LLC
        </div>
        <img src="img/image001.png" alt="">
        <div class="lower-text fs-5 text-black">
            <span>Prepared Date: {{ $prepared_date }}</span>
            <span>Estimator: Taylor Ivens</span>
            <span>Project Manager: {{ $project_manager }}</span>
        </div>
    </div>

</section>
<!-- section-two -->
<div class="container">
    <h2 class="d-flex align-left   text-decoration-underline">Inclusions:</h2>
    <p  class="d-flex text-start  ">{{ $inclusion }}</p>
</div>

<!-- section-three -->

{{--<h2 class="container d-flex align-left   text-decoration-underline mt-2">30-Year Architectural Shingles (Certainteed Landmark):</h2>--}}


{{--<div class="container mt-2 d-flex text-start">--}}


{{--    <ul >--}}
{{--        <li>Install synthetic underlayment to the entire substrate</li>--}}
{{--        <li>Install 2” X 2” drip edge flashing to all eaves- Color TBD</li>--}}
{{--        <li >Install Ice & water shield to all specified locations</li>--}}
{{--        <li >Install galvanized pipe jack boots as needed</li>--}}
{{--        <li >Paint all penetration pipes with manufacturer recommended paint</li>--}}
{{--        <li >Fabricate and install headwall and sidewall flashing  </li>--}}
{{--        <li >Install starter shingles along all eaves and rakes</li>--}}
{{--        <li >Install 30-Year architectural shingles to the field of the roof</li>--}}
{{--        <li >Install corresponding hip and ridge shingles to ridge cap</li>--}}
{{--        <li>Clear and haul off all job-related debris</li>--}}
{{--    </ul>--}}
{{--</div>--}}
{{--<h2 class="container d-flex align-start   text-decoration-underline">60 Mil TPO (Mule-Hide):</h2>--}}
{{--<div class="container mt-2 d-flex text-start">--}}


{{--    <ul >--}}
{{--        <li>Mechanically Attach ½” Cover Board to substrate (R-Value 2.5)</li>--}}
{{--        <li>Install 60 Mil TPO to field and walls (Fully Adhered)</li>--}}
{{--        <li>Flash Shingle to TPO transition</li>--}}
{{--        <li>Install edge flashing to all eaves- Color TBD</li>--}}
{{--        <li>Install 891 Linear Feet of Termination Bar</li>--}}
{{--        <li>Clear and haul off all job-related debris</li>--}}
{{--    </ul>--}}
{{--</div>--}}
<!-- section-four-->
<div class="container mt-2 text-start">
    <h2>Exclusions:</h2>
    <ul >
        {{ $exclusions }}
{{--        <li>Rough Carpentry (wood nailers, decking, blocking, cants, and sheathing).</li>--}}
{{--        <li>Painting.</li>--}}
{{--        <li>MEP, flashings, curbs, pitch plans, and accessories.</li>--}}
{{--        <li>Sheet Metal not related to roofing.</li>--}}
{{--        <li>Protection of roof from other trades.</li>--}}
{{--        <li>Canopy/Awning roofing and trim.</li>--}}
{{--        <li>Scupper Boxes and Scupper Box Downspouts.</li>--}}
{{--        <li>Post installation roof penetration tie-ins. (additional $750 for mobilization)</li>--}}
    </ul>
    {!! nl2br($chatGPTResponse) !!}
{{--    <h2 class="mt-4">Lead Times:</h2>--}}
{{--    <li>Expected lead time at the time of bidding is 2 - 3 weeks.</li>--}}


{{--    <p><strong><u>Building A:</u></strong> Shingle: 340.66 SQ / TPO: 93.74 SQ</p>--}}
{{--    <p>Total: $244,375.00</p>--}}

{{--    <p> <strong><u>Building B:</u></strong> Shingle: 220 SQ / TPO: 59.34 SQ</p>--}}
{{--    <p>Total: $157,835.00</p>--}}

{{--    <p> <strong><u>Building C:</u></strong>Shingle: 236.43 SQ / TPO: 62.07 SQ</p>--}}
{{--    <p>Total: $169,580.00</p>--}}

{{--    <p><strong><u>Maintenance :</u></strong> Shingle: 32.59 SQ</p>--}}
{{--    <p>Total: $23,370.00</p>--}}

{{--    <p><strong><u>Garage (2):</u></strong> Shingle: 20.69 SQ</p>--}}
{{--    <p>Total Per Garage: $14,840.00</p>--}}
{{--    <p>Total: $29,680.00</p>--}}

{{--    <p><strong><u>Gutters:</u></strong>$34,910.00</p>--}}
{{--    <p>1,815 Linear Feet of 5” K- Style Gutters - Aluminum</p>--}}
{{--    <p>3,276 Linear Feet of 2x3 Downspouts</p>--}}

{{--    <p style="color: #cc4125;">--}}
{{--        SKYTRAK Telehandler:Not included in pricing</p>--}}
{{--    <p style="color: #cc4125;">$7,000.00/month for rental</p>--}}
{{--</div>--}}
{{--<!-- section-five-->--}}
{{--<div class="container mt-2 text-start">--}}
{{--    <h5>Total: $659,750.00</h5>--}}

    <h5 class="mt-4">Payment Schedule:</h5>
    <p>{{ $payment_schedule }}</p>

    <h5 class="mt-4">Price Escalation Clause:</h5>
    <p>{{ $price_escalation_clause }}</p>

    <h5 class="mt-4">Alterations:</h5>
    <p>{{ $alterations }}</p>

    <h5 class="mt-4">Compliance:</h5>
    <p>{{ $compliance }}</p>

    <h5 class="mt-4">Timeline:</h5>
    <p>{{ $timeline }}</p>

    <h5 class="mt-4">Warranty:</h5>
    <p>{{ $warranty_clause }}</p>

    <h5 class="mt-4">Contract Bid Accepted By:</h5>
    <p>Name: ______________________________</p>
    <p>Title: _______________________________</p>
    <p>Signature: ___________________________</p>
    <p>Date: _______________________________</p>
</div>

<footer>
    <div class="container text-center mt-2 fs-5">
        <p><span>706 W. Ben White Blvd Suite 233a Austin, TX 78704</span> | <span>PH: 512.645.1687</span> | <span>sales@loaconstruction.com</span></p>
        <p><span>www.loaconstruction.com</span> | <span>New Construction Estimate</span></p>

</footer>
</body>
</html>
