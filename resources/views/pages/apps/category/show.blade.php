<x-default-layout>

    @section('title')
        Category
    @endsection

{{--    @section('breadcrumbs')--}}
{{--        {{ Breadcrumbs::render('user-management.users.show', $user) }}--}}
{{--    @endsection--}}

    <!--begin::Layout-->
        <script src="{{ asset('columns/_draw-scripts.js') }}"></script>

        <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
{{--            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">--}}
{{--                <!--begin:::Tab item-->--}}
{{--                <li class="nav-item ms-auto">--}}
{{--                    <!--begin::Action menu-->--}}
{{--                    <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions--}}
{{--                        <i class="ki-duotone ki-down fs-2 me-0"></i></a>--}}
{{--                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">--}}
{{--                        <div class="menu-item px-5">--}}
{{--                            <a href="#" class="menu-link px-5" data-kt-category-id="{{ $productCategory->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_category" data-kt-action="update_row">Edit Category</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!--end::Menu-->--}}
{{--                </li>--}}
{{--                <!--end:::Tab item-->--}}
{{--            </ul>--}}
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <div class="card-body p-9">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-lg-6">
                                    <!-- Full Name -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Category Name</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{ $productCategory->name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created at</label>
                                        <div class="col-lg-8">
                                            <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ $productCategory->created_at }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Descripion</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{ $productCategory->description }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created By</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $productCategory->user->name }}</span>
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
