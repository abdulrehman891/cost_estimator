<div  class="modal fade" id="kt_modal_add_project" tabindex="-1" aria-hidden="true" wire:ignore.self>

{{-- Do your work, then step back. --}}
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_product_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Project</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_project_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Project Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="project_name" name="project_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Name"/>
                            <!--end::Input-->
                            @error('project_name') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="textarea" wire:model.defer="address" name="address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Address"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="textarea" wire:model.defer="description" name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description"/>
                            <!--end::Input-->
                        </div>

                        <div class="fv-row mb-7">
                                <label for="image" class="fw-semibold fs-6 mb-2">Image</label>
                                <input wire:model.defer="image" accept="image/png,image/jpeg" type="file" id="image" class="form-control mb-3 mb-lg-0">
                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Start Date</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid"  wire:model.defer="expected_start_date" placeholder="Pick a date" name="expected_start_date" id="expected_start_date"/>
                            <!--end::Input-->
                            @error('expected_start_date') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">End Date</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid"  wire:model.defer="expected_end_date" placeholder="Pick a date" name="expected_end_date" id="expected_end_date"/>
                            <!--end::Input-->
                            @error('expected_end_date') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Project Size</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="project_size" name="project_size" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Size"/>
                            <!--end::Input-->
                            @error('project_size') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Project Type</label>
                            <!--end::Label-->
                            <select class="form-select" wire:model.defer="project_type" name="project_type" id="project_type" data-placeholder="Select an option">
                                <option>Select an option</option>
                                <option value="commercial">Commercial</option>
                                <option value="industrial">Industrial</option>
                            </select>
                            @error('project_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="fv-row mb-7" wire:ignore>
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Project Manager</label>
                            <!--end::Label-->
                            <select class="form-select" name="project_manager" id="project_manager" data-control="select2" data-dropdown-parent="#kt_modal_add_project" data-placeholder="Select an option">
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
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
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
        @push('scripts')
            <script>
                $('#project_manager').select2();
                $('#project_manager').on('change',function (e){
                    var data = $('#project_manager').select2('val')
                @this.set('project_manager',data)
                });
            </script>
        @endpush
    </div>

</div>
