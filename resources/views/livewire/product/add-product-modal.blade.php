<div  class="modal fade" id="kt_modal_add_product" tabindex="-1" aria-hidden="true" wire:ignore.self>
    {{-- The Master doesn't talk, he acts. --}}

    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_product_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Product</h2>
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
                <form id="kt_modal_add_product_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Product Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="product_name" name="product_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Product Name"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="textarea" wire:model.defer="description" name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description"/>
                            <!--end::Input-->
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Product SKU</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="sku" name="sku" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="SKU"/>
                            <!--end::Input-->
                        </div>


                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="description" class="required fw-semibold fs-6 mb-2">Price</label>
                                <input type="text" wire:model.defer="price" id="price" name="price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Price"/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="created_by" class="required fw-semibold fs-6 mb-2">Stock Quantity</label>
                                <input type="text" wire:model.defer="stock_quantity" id="stock_quantity" name="stock_quantity" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Stock Quantity"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="description" class="required fw-semibold fs-6 mb-2">Category</label>
                                <select class="form-select" wire:model="selectedCategory" name="category_name" id="category_name" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="created_by" class="required fw-semibold fs-6 mb-2">Sub-Category</label>
                                <select class="form-select" wire:model.defer="sub_category" name="sub_category" id="sub_category" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="description" class="required fw-semibold fs-6 mb-2">Weight</label>
                                <input type="text" wire:model.defer="weight" id="weight" name="weight" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Weight"/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="created_by" class="required fw-semibold fs-6 mb-2">Width</label>
                                <input type="text" wire:model.defer="width" id="width" name="width" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Width"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="description" class="required fw-semibold fs-6 mb-2">Length</label>
                                <input type="text" wire:model.defer="length" id="length" name="length" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Length"/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="created_by" class="required fw-semibold fs-6 mb-2">Height</label>
                                <input type="text" wire:model.defer="height" id="height" name="height" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Height"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="description" class="required fw-semibold fs-6 mb-2">Color</label>
                                <input type="text" wire:model.defer="color" id="color" name="color" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Color"/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="created_by" class="required fw-semibold fs-6 mb-2">Material</label>
                                <input type="text" wire:model.defer="material" id="material" name="material" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Matrial"/>
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
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>
