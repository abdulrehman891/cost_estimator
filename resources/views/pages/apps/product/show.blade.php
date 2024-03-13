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

{{--           <div class="card">--}}

{{--                <!--begin::Card body-->--}}
{{--               <div class="card-body py-4" >--}}
{{--                    <!--begin::Table-->--}}
{{--                    <div class="table-responsive">--}}
{{--                        <div id="customer-table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" >--}}
{{--                        {{ $productHistoryTable->table() }}--}}
{{--                        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold" id="customer-table" style="width: 1537px;">--}}
{{--                            <thead class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">--}}
{{--                                <tr>--}}
{{--                                    <th title="Name" class="sorting" tabindex="0" aria-controls="customer-table" rowspan="1" colspan="1"--}}
{{--                                        aria-label="Name: activate to sort column ascending" style="width: 204px;">Old Price</th>--}}
{{--                                    <th title="Email" class="sorting" tabindex="0" aria-controls="customer-table" rowspan="1" colspan="1"--}}
{{--                                        aria-label="Email: activate to sort column ascending" style="width: 321.25px;">New Price</th>--}}
{{--                                    <th title="Email" class="sorting" tabindex="0" aria-controls="customer-table" rowspan="1" colspan="1"--}}
{{--                                        aria-label="Email: activate to sort column ascending" style="width: 321.25px;">Created at</th>--}}

{{--                                </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($product_price_history as $productPriceHistory)--}}
{{--                                <tr id="{{ $productPriceHistory->id }}" class="odd">--}}
{{--                                    <td>{{ $productPriceHistory->old_unit_price }}</td>--}}
{{--                                    <td>{{ $productPriceHistory->new_unit_price }}</td>--}}
{{--                                    <td>{{ $productPriceHistory->created_at }}</td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    <!--end::Table-->--}}
{{--                        </div>--}}
{{--                </div>--}}
{{--                <!--end::Card body-->--}}
{{--               </div>--}}
{{--            </div>--}}
    <div class="flex-lg-row-fluid ms-lg-10">
            <!--begin::Card-->
            <div class="card card-flush mb-6 mb-xl-9">
                <!--begin::Card header-->
                <div class="card-header pt-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="d-flex align-items-center">Product Price History
{{--                            <span class="text-gray-600 fs-6 ms-1">({{ $role->users->count() }})</span>--}}
                        </h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>

        @push('scripts')
            {{ $dataTable->scripts() }}
        @endpush



</x-default-layout>

