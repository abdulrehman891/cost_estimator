<x-default-layout>

    @section('title')
        Quotation Template
    @endsection

    {{--    @section('breadcrumbs')--}}
    {{--        {{ Breadcrumbs::render('user-management.users.show', $user) }}--}}
    {{--    @endsection--}}

    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--begin:::Tab item-->
                <li class="nav-item ms-auto">
                    <!--begin::Action menu-->
                    <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions
                        <i class="ki-duotone ki-down fs-2 me-0"></i></a>
                    <!--end::Menu-->
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_quote_template_detail_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <div class="card-body p-9">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-lg-6">
                                    <!-- Full Name -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Name</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{ $quotation_template->name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Assembly Type</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{ $quotation_template->assembly_type }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created at</label>
                                        <div class="col-lg-8">
                                            <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ $quotation_template->created_at }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Prepared Date</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{ $quotation_template->prepared_date }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created By</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $quotation_template->user->name }}</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">SQ Field</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{ $quotation_template->sq_field }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Parapet Length</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $quotation_template->parapet_length }}</span>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">SQ Walls</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{ $quotation_template->sq_walls }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Building Height</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $quotation_template->building_height }}</span>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Deck Type</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{ $quotation_template->deck_type }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>

</x-default-layout>
