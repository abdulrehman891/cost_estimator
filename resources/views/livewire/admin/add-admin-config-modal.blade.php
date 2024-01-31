<div  class="modal fade" id="kt_modal_add_adminconfig" tabindex="-1" aria-hidden="true" wire:ignore.self>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_admin_config_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Admin Config</h2>
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
                <form id="kt_modal_add_admin_config_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_admin_config_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_admin_config_header" data-kt-scroll-wrappers="#kt_modal_add_admin_config_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Key</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="key" id="key" name="key" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Key"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Value</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            {{-- <input type="textarea" wire:model.defer="value" id="value" name="value" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Value"/> --}}
                            <textarea wire:model.defer="value" name="value"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Value"> </textarea>
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-7">
                            {{-- <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">For AI Prompt?</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="radio" wire:model.defer="for_ai_prompt" name="for_ai_prompt" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="For AI Prompt?"/>
                            <!--end::Input--> --}}
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" wire:model.defer="for_ai_prompt" name="for_ai_prompt" id="for_ai_prompt" type="checkbox" value="true">
                                <span class="form-check-label fw-semibold text-muted">For AI Prompt?</span>
                            </label>
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
    </div>
</div>
