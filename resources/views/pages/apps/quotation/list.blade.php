<x-default-layout>

    @section('title')
        Quotation
    @endsection

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!--begin::Heading--> 
        @if(!empty($user->subscription_ends_at))
            <div class="mb-13 text-center">    
                <h1 class="mb-3">Your {{$package['title']}} Details:</h1>
                <h3>Quota Expiry Date:<span class="badge badge-light-success me-4">{{$user->subscription_ends_at}} UTC</span></h3>
                <h3>Quotes Generation Remaining Quota:<span class="badge badge-light-success me-4">{{$user->subscription_remaining_quota}}</span></h3>
            </div>
        @endif
    <!--end::Heading-->

    @section('breadcrumbs')
        {{ Breadcrumbs::render('quotation.list') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Quotation" id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            @can("create quotations")
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_quotation">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add Quotation
                    </button>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Modal-->
                <livewire:quotation.add-quotation-modal></livewire:quotation.add-quotation-modal>
                <!--end::Modal-->
            </div>
            <!--end::Card toolbar-->
            @endcan

        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['quotations-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-table'].ajax.reload();
                });
            });
            //prepared_date

            // $("#prepared_date").flatpickr({
            //     onReady: function () {
            //     },
            //     dateFormat: "Y-m-d",
            // });
            //
            // $("#expected_start_date").flatpickr({
            //     onReady: function () {
            //     },
            //     dateFormat: "Y-m-d",
            // });
            //
            // $("#expected_end_date").flatpickr({
            //     onReady: function () {
            //     },
            //     dateFormat: "Y-m-d",
            // });
        </script>
    @endpush

</x-default-layout>
