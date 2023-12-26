<x-default-layout>

    @section('title')
        Product
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
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <div class="card-body p-9">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-lg-6">
                                    <!-- Full Name -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Product Name</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$product->product_name}}</span>
                                        </div>
                                    </div>

                                    <!-- Company -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Price</label>
                                        <div class="col-lg-8 fv-row">
                                            <span class="fw-semibold text-gray-800 fs-6">{{$product->price}}</span>
                                        </div>
                                    </div>

                                    <!-- Contact Phone -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Length</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->length}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Height</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->height}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Color</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->color}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Category</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->product_category ? $product->product_category->name : ""}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">SKU</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->sku}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created By</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->user->name}}</span>
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
                                            <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{$product->description}}</a>
                                        </div>
                                    </div>

                                    <!-- Country -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Weight</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$product->weight}}</span>
                                        </div>
                                    </div>

                                    <!-- Communication -->
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Width</label>
                                        <div class="col-lg-8">
                                            <span class="fw-bold fs-6 text-gray-800">{{$product->width}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Material</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->material}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Stock Quantity</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->stock_quantity}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Sub-Category</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->product_subcategory ? $product->product_subcategory->name : ""}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-4 fw-semibold text-muted">Created At</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <span class="fw-bold fs-6 text-gray-800 me-2">{{$product->created_at}}</span>
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
