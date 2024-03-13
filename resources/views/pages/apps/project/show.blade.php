<x-default-layout>

    @section('title')
        Project
    @endsection

    {{--    @section('breadcrumbs')--}}
    {{--        {{ Breadcrumbs::render('user-management.users.show', $user) }}--}}
    {{--    @endsection--}}

    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
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
                                        <label class="col-lg-4 fw-semibold text-muted">Project Name</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$project->name}}</span>
                                        </div>
                                    </div>
                                    <!-- Company -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Expected Start Date</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{$project->expected_start_date}}</span>
                                        </div>
                                    </div>
                                    <!-- Contact Phone -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Project Type</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$project->project_type}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created By</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$project->user->name}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created At</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$project->created_at}}</span>
                                        </div>
                                    </div>
                                    <!-- Add more rows/columns as needed -->
                                </div>
                                <!-- Column 2 -->
                                <div class="col-lg-6">
                                    <!-- Company Site -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Description</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$project->description}}</span>
                                        </div>
                                    </div>
                                    <!-- Country -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Expected End Date</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$project->expected_end_date}}</span>
                                        </div>
                                    </div>
                                    <!-- Communication -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Project Size</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$project->project_size}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Project Manager</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$project->manager->name}}</span>
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
