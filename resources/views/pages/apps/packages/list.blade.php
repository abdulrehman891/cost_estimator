<x-default-layout>

    @section('title')
        Please subscribe to one of the packages below to get access to The Quote Generation Feature:
    @endsection

    <div class="card">        
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                @foreach($packages as $package)
                    <a href='{{ route('pruchase_package', ['the_package' => $package->identifier]) }}' target='_blank'>
                    <button type="button" class="btn btn-primary" >
                        <i class="ki-duotone ki-add fs-2"></i>
                        {{$package->title}} at @ ${{$package->price_usd}}/{{$package->validity_days}} Days
                    </button>
                    </a>
                @endforeach
            </div>
            <!--end::Table-->

             
        <!--end::Card body-->
    </div>
</x-default-layout>