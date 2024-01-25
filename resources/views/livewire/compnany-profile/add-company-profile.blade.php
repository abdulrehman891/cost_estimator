<div class="px-5 my-7">
    <form id="kt_modal_add_company_profile_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
        <!--begin::Scroll-->
        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="description" class="required fw-semibold fs-6 mb-2">Company Name</label>
                    <input type="text" wire:model.defer="company_name" id="company_name"  name="company_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Company Name"/>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="created_by" class="required fw-semibold fs-6 mb-2">Slogan</label>
                    <input type="text" wire:model.defer="slogan" id="slogan" name="slogan" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Slogan"/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="description" class="required fw-semibold fs-6 mb-2">description</label>
                    <input type="text" wire:model.defer="description"  id="description" name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description"/>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="created_by" class="required fw-semibold fs-6 mb-2">Address</label>
                    <input type="text" wire:model.defer="address" id="address" name="address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Address"/>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="description" class="required fw-semibold fs-6 mb-2">Phone Number</label>
                    <input type="text" wire:model.defer="phone_number" id="phone_number" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone Number"/>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="created_by" class="required fw-semibold fs-6 mb-2">Website</label>
                    <input type="text" wire:model.defer="website" id="website" name="website" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Website"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="description" class="required fw-semibold fs-6 mb-2">Email</label>
                    <input type="text" wire:model.defer="email" id="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email"/>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="created_by" class="required fw-semibold fs-6 mb-2">Established Year</label>
                    <input class="form-control form-control-solid" wire:model.defer="established_date" placeholder="Pick a date" name="established_date" id="established_date"/>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="description" class="required fw-semibold fs-6 mb-2">Logo</label>
                    <input wire:model.defer="image" accept="image/png,image/jpeg" type="file" id="image" class="form-control mb-3 mb-lg-0">
                    @if($image)
                        @if($edit_mode == true)
                            <img class="w-25 p-1" src="{{ asset('storage/'.$image) }}" alt="" />
                            @if($image_updated == true)
                                <img class="w-25 p-1" src="{{ $image->temporaryUrl() }}" alt="" />
                            @endif
                        @else
                            <img class="w-25 p-1" src="{{ $image->temporaryUrl() }}" alt="" />
                        @endif
                    @endif
                </div>

            </div>
            <!--end::Input group-->
            <!--begin::Input group-->

            <!--end::Input group-->
        </div>
        <!--end::Scroll-->
        <!--begin::Actions-->
        <div class="text-center pt-15">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">Discard</button>
            <button type="submit" class="btn btn-primary" data-kt-product-modal-action="submit">
                <span class="indicator-label" wire:loading.remove>Submit</span>
                <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
            </button>
        </div>
        <!--end::Actions-->
    </form>
</div>


</div>
<!--end::Card-->
</div>
<!--end:::Tab pane-->
</div>
<!--end:::Tab content-->
</div>
