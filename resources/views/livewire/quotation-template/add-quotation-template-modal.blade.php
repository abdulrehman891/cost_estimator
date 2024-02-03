<div class="modal fade" wire:ignore.self id="kt_modal_add_quotation_template" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-fullscreen p-9">
        <!--begin::Modal content-->
        <div class="modal-content modal-rounded">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Create Quotation Template</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-5">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills" id="kt_stepper_example_clickable">
                    <!--begin::Form-->
                    <form class="form w-lg-700px mx-auto" wire:submit.prevent="submit" novalidate="novalidate"
                        id="kt_stepper_example_basic_form">
                        <!--begin::Group-->


                        <!--begin::Step 1-->
                        @if ($currentStep == 1)
                            <div class="card">
                                <div class="card-header bg-secondary text-black">
                                    <h3 class="card-title">STEP 1/2 - Quotation Template</h3>
                                </div>
                                <div class="card-body">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Name</label>
                                            <input type="text" wire:model.defer="name"
                                                name="name"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Name" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Assembly Type</label>
                                            <input type="textarea" wire:model.defer="assembly_type"
                                                name="assembly_type"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Assembly Type" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Manufacturer</label>
                                            <input type="text" wire:model.defer="manufacturer" name="manufacturer"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Manufacturer" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">SQ Walls</label>
                                            <input type="text" wire:model.defer="sq_walls" name="sq_walls"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="SQ Walls" />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">SQ Field</label>
                                            <input type="text" wire:model.defer="sq_field" name="sq_field"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="SQ Field" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Warranty</label>
                                            <input type="text" wire:model.defer="warranty" name="warranty"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Warranty" />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Parapet Length</label>
                                            <input type="text" wire:model.defer="parapet_length"
                                                name="parapet_length"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Parapet Length" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Building Height</label>
                                            <input type="text" wire:model.defer="building_height"
                                                name="building_height"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Building Height" />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Deck Type</label>
                                            <input wire:model.defer="deck_type" type="text" name="deck_type"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Deck Type" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Inclusions</label>
                                            <textarea wire:model.defer="inclusions" name="inclusions" class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Inclusions"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Exclusions</label>
                                            <textarea name="exclusions" wire:model.defer="exclusions" class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Exclusions"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Payment Schedule</label>
                                            <textarea name="payment_schedule" wire:model.defer="payment_schedule"
                                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Payment Schedule"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Price Escalation
                                                Clause</label>
                                            <textarea name="price_escalation_clause" wire:model.defer="price_escalation_clause"
                                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Price Escalation Clause"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Alterations</label>
                                            <textarea name="alterations" wire:model.defer="alterations" class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Alterations"> </textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Compliance</label>
                                            <input type="text" wire:model.defer="compliance" name="compliance"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Compliance" />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Timelines</label>
                                            <input type="text" wire:model.defer="timelines" name="timelines"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="Timelines" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-10">
                                            <label class="required fw-semibold fs-6 mb-2">Warranty Clause</label>
                                            <textarea wire:model.defer="warranty_clause" name="warranty_clause"
                                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Warranty Clause"> </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!--end::Step 1-->

                        <!--begin::Step 2-->
                        @if ($currentStep == 2)
                            <div class="card">
                                <div class="card-header bg-secondary text-black">
                                    <h3 class="card-title">STEP 2/2 - QouteTemplate Line Item</h3>
                                </div>
                                <div class="card-body">
                                    <!--begin::Repeater-->
                                    <div id="quote_template_line_items">
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <div data-repeater-list="quote_template_line_items">
                                                <div data-repeater-item>
                                                    @foreach ($quoteTemplateLineItems as $index => $quoteLine)
                                                        <div class="card m-2">

                                                            <!--begin::Input group-->
                                                            <div class="fv-row m-5">
                                                                <!--begin::Label-->
                                                                <label
                                                                    class="required fw-semibold fs-6 mb-2">Product</label>
                                                                <!--end::Label-->
                                                                <select wire:model="products.{{ $index }}"
                                                                    class="form-select" name="product"
                                                                    data-placeholder="Select an option">
                                                                    <option></option>
                                                                    @foreach ($products_list as $product)
                                                                        <option value="{{ $product->id }}"
                                                                            data-unitprice="{{ $product->price }}">
                                                                            {{ $product->product_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <!--end::Input group-->
                                                            <div class="form-group row m-5">
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Unit
                                                                        Price</label>
                                                                    <input wire:model="unit_price.{{ $index }}"
                                                                        type="text" name="unit_price"
                                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                                        placeholder="Unit Price" />
                                                                </div>
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="fw-semibold fs-6 mb-2">Discount Price
                                                                        (On Total Price)</label>
                                                                    <input
                                                                        wire:model.defer="discount_price.{{ $index }}"
                                                                        type="text" name="discount_price"
                                                                        onkeyup="changeDiscountEvent(this)"
                                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                                        placeholder="Discount Price" />
                                                                </div>

                                                                <div class="col-md-6 mb-4">
                                                                    <label
                                                                        class="required fw-semibold fs-6 mb-2">Quantity</label>
                                                                    <input wire:model="quantity.{{ $index }}"
                                                                        type="text" name="quantity"
                                                                        onkeyup="changeQuantityEvent(this)"
                                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                                        placeholder="Quantity" />
                                                                </div>

                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Total
                                                                        Price</label>
                                                                    <input
                                                                        wire:model.defer="total_price.{{ $index }}"
                                                                        type="text" name="total_price"
                                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                                        placeholder="Total Price" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-5">
                                                                <div class="col-md-12 text-center">
                                                                    <button class="btn btn-danger"
                                                                        wire:click.prevent="removeQouteTemplateLine({{ $index }})">
                                                                        Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Form group-->



                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <button class="btn btn-primary" wire:click.prevent="addQuoteTemplateLine">
                                                Add</button>
                                        </div>
                                        <!--end::Form group-->
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!--end::Step 2-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Wrapper-->
                            @if ($currentStep > 1)
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary"
                                        wire:click.prevent="decreaseStep">
                                        Back
                                    </button>
                                </div>
                            @endif
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div id="wrapper_section">
                                @if ($currentStep == 2)
                                    <button type="submit" class="btn btn-primary"
                                        data-kt-quotation-template-modal-action="submit">
                                        <span class="indicator-label" wire:loading.remove>Submit & Continue</span>
                                        <span class="indicator-progress" wire:loading wire:target="submit">
                                            Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                @endif
                                @if ($currentStep < 2)
                                    <button type="button" wire:click="" class="btn btn-primary"
                                        data-kt-stepper-action="next" id="continue_next"
                                        wire:click.prevent="increaseStep">
                                        Continue
                                    </button>
                                @endif
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        {{--                            </div> --}}
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>

@push('scripts')
    <script>
        $("#expected_start_date").flatpickr({
            onReady: function() {},
            dateFormat: "Y-m-d",
        });

        $("#expected_end_date").flatpickr({
            onReady: function() {},
            dateFormat: "Y-m-d",
        });

    </script>
@endpush
