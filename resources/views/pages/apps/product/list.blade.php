<x-default-layout>

    @section('title')
        Product
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('products.list') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search product" id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            @can("create products")
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
{{--                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_product">--}}
{{--                        {!! getIcon('plus', 'fs-2', '', 'i') !!}--}}
{{--                        Add Product--}}
{{--                    </button>--}}
                    <!--end::Add user-->

                    <div class="btn-group dropdown">


                        <ul class="dropdown-menu">
                            <li> <a class="btn btn-primary" href="{{ url('export-products') }}">
                                    Export User Data
                                </a></li>
                            <li> <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                         data-bs-target="#staticBackdrop">
                                    Import User Data
                                </button></li>

                        </ul>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_product">
                            {!! getIcon('plus', 'fs-2', '', 'i') !!}
                            Add Product
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropend</span>
                        </button>
                    </div>
                </div>
                <!--end::Toolbar-->

                <!--begin::Modal-->
                <livewire:product.add-product-modal></livewire:product.add-product-modal>
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
        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Launch static backdrop modal
        </button> --}}

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Select Import File</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('excel-import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control">
                            <br>
                            <button class="btn btn-success">
                                Import User Data
                            </button>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['products-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_add_product').modal('hide');
                    window.LaravelDataTables['products-table'].ajax.reload();
                });
            });
        </script>
    @endpush

</x-default-layout>
