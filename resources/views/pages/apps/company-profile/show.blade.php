<x-default-layout>

    @section('title')
        Company Profile
    @endsection

    {{--    @section('breadcrumbs')--}}
    {{--        {{ Breadcrumbs::render('user-management.users.show', $user) }}--}}
    {{--    @endsection--}}

    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        @if (empty(auth()->user()->companyProfile->signnow_brand_id))
                        <p class="alert alert-warning">Please complete your company profile including with logo image to proceed..</p>
                        @endif
                        <div class="card-body p-9">
                            <span>
                                Company Profile
                            </span>
                        </div>
                        <livewire:compnany-profile.add-company-profile></livewire:compnany-profile.add-company-profile>
        <!--end::Content-->
        @push('scripts')
            <script>
                    $("#established_date").flatpickr({
                        onReady: function () {
                        },
                        dateFormat: "Y",
                    });
            </script>
        @endpush
    </div>

</x-default-layout>
