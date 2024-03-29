<x-default-layout>

    @section('title')
        Product Price History
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('product-price-history.list') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Product Price History" id="productPriceHistorySearch"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

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
            document.getElementById('productPriceHistorySearch').addEventListener('keyup', function () {
                window.LaravelDataTables['product-price-history-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    window.LaravelDataTables['product-price-history-table'].ajax.reload();
                });
            });
        </script>
    @endpush

</x-default-layout>
