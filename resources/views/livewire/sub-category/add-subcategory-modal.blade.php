<div  class="modal fade" id="kt_modal_add_subcategory" tabindex="-1" aria-hidden="true" wire:ignore.self>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_product_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Category</h2>
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
                <form id="kt_modal_add_subcategory_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Sub-Category Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="sub_category_name" name="sub_category_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Sub-Category Name"/>
                            @error('sub_category_name') <span class="text-danger">{{ $message }}</span> @enderror
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-7" >
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Category Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div wire:ignore>
                                <select wire:model="product_category" class="form-select" name="selected_category" id="selected_category" data-control="select2" data-dropdown-parent="#kt_modal_add_subcategory" data-placeholder="Select a Category">
                                    <option></option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"  {{ $product_category == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input-->
                            @error('product_category') <span class="text-danger">{{ $message }}</span> @enderror
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
        <script>
            document.addEventListener('livewire:load', function () {
                $('#selected_category').select2();
                $('#selected_category').on('change',function (e){
                    let data = $(this).val();
                    @this.set('product_category',data);

                });
                window.livewire.on('data-change-event', () =>{
                    $('#selected_category').select2({
                        closeOnSelect: true
                    });
                });
            })
          </script>
</div>

