 <div class="modal fade" wire:ignore.self id="kt_modal_add_quotation" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-fullscreen p-9">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Create Quotation</h2>
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
                        <!--begin::Nav-->
{{--                        <div class="stepper-nav flex-center flex-wrap mb-10">--}}
{{--                            <!--begin::Step 1-->--}}
{{--                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav" data-kt-stepper-action="step">--}}
{{--                                <!--begin::Wrapper-->--}}
{{--                                <div class="stepper-wrapper d-flex align-items-center">--}}
{{--                                    <!--begin::Icon-->--}}
{{--                                    <div class="stepper-icon w-40px h-40px">--}}
{{--                                        <i class="stepper-check fas fa-check"></i>--}}
{{--                                        <span class="stepper-number">1</span>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Icon-->--}}

{{--                                    <!--begin::Label-->--}}
{{--                                    <div class="stepper-label">--}}
{{--                                        <h3 class="stepper-title">--}}
{{--                                            Step 1--}}
{{--                                        </h3>--}}

{{--                                        <div class="stepper-desc">--}}
{{--                                            <h6>Project</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Label-->--}}
{{--                                </div>--}}
{{--                                <!--end::Wrapper-->--}}

{{--                                <!--begin::Line-->--}}
{{--                                <div class="stepper-line h-40px"></div>--}}
{{--                                <!--end::Line-->--}}
{{--                            </div>--}}
{{--                            <!--end::Step 1-->--}}

{{--                            <!--begin::Step 2-->--}}
{{--                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">--}}
{{--                                <!--begin::Wrapper-->--}}
{{--                                <div class="stepper-wrapper d-flex align-items-center">--}}
{{--                                    <!--begin::Icon-->--}}
{{--                                    <div class="stepper-icon w-40px h-40px">--}}
{{--                                        <i class="stepper-check fas fa-check"></i>--}}
{{--                                        <span class="stepper-number">2</span>--}}
{{--                                    </div>--}}
{{--                                    <!--begin::Icon-->--}}

{{--                                    <!--begin::Label-->--}}
{{--                                    <div class="stepper-label">--}}
{{--                                        <h3 class="stepper-title">--}}
{{--                                            Step 2--}}
{{--                                        </h3>--}}

{{--                                        <div class="stepper-desc">--}}
{{--                                            <h6>Project Milestone</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Label-->--}}
{{--                                </div>--}}
{{--                                <!--end::Wrapper-->--}}

{{--                                <!--begin::Line-->--}}
{{--                                <div class="stepper-line h-40px"></div>--}}
{{--                                <!--end::Line-->--}}
{{--                            </div>--}}
{{--                            <!--end::Step 2-->--}}


{{--                            <!--begin::Step 3-->--}}
{{--                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">--}}
{{--                                <!--begin::Wrapper-->--}}
{{--                                <div class="stepper-wrapper d-flex align-items-center">--}}
{{--                                    <!--begin::Icon-->--}}
{{--                                    <div class="stepper-icon w-40px h-40px">--}}
{{--                                        <i class="stepper-check fas fa-check"></i>--}}
{{--                                        <span class="stepper-number">3</span>--}}
{{--                                    </div>--}}
{{--                                    <!--begin::Icon-->--}}

{{--                                    <!--begin::Label-->--}}
{{--                                    <div class="stepper-label">--}}
{{--                                        <h3 class="stepper-title">--}}
{{--                                            Step 3--}}
{{--                                        </h3>--}}

{{--                                        <div class="stepper-desc">--}}
{{--                                            <h6>Quotation</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Label-->--}}
{{--                                </div>--}}
{{--                                <!--end::Wrapper-->--}}

{{--                                <!--begin::Line-->--}}
{{--                                <div class="stepper-line h-40px"></div>--}}
{{--                                <!--end::Line-->--}}
{{--                            </div>--}}
{{--                            <!--end::Step 3-->--}}

{{--                            <!--begin::Step 4-->--}}
{{--                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">--}}
{{--                                <!--begin::Wrapper-->--}}
{{--                                <div class="stepper-wrapper d-flex align-items-center">--}}
{{--                                    <!--begin::Icon-->--}}
{{--                                    <div class="stepper-icon w-40px h-40px">--}}
{{--                                        <i class="stepper-check fas fa-check"></i>--}}
{{--                                        <span class="stepper-number">4</span>--}}
{{--                                    </div>--}}
{{--                                    <!--begin::Icon-->--}}

{{--                                    <!--begin::Label-->--}}
{{--                                    <div class="stepper-label">--}}
{{--                                        <h3 class="stepper-title">--}}
{{--                                            Step 4--}}
{{--                                        </h3>--}}

{{--                                        <div class="stepper-desc">--}}
{{--                                            <h6>Quote Line Items</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Label-->--}}
{{--                                </div>--}}
{{--                                <!--end::Wrapper-->--}}

{{--                                <!--begin::Line-->--}}
{{--                                <div class="stepper-line h-40px"></div>--}}
{{--                                <!--end::Line-->--}}
{{--                            </div>--}}
{{--                            <!--end::Step 4-->--}}

{{--                            <!--begin::Step 5-->--}}
{{--                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">--}}
{{--                                <!--begin::Wrapper-->--}}
{{--                                <div class="stepper-wrapper d-flex align-items-center">--}}
{{--                                    <!--begin::Icon-->--}}
{{--                                    <div class="stepper-icon w-40px h-40px">--}}
{{--                                        <i class="stepper-check fas fa-check"></i>--}}
{{--                                        <span class="stepper-number">5</span>--}}
{{--                                    </div>--}}
{{--                                    <!--begin::Icon-->--}}

{{--                                    <!--begin::Label-->--}}
{{--                                    <div class="stepper-label">--}}
{{--                                        <h3 class="stepper-title">--}}
{{--                                            Step 5--}}
{{--                                        </h3>--}}

{{--                                        <div class="stepper-desc">--}}
{{--                                            <h6>Completion</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Label-->--}}
{{--                                </div>--}}
{{--                                <!--end::Wrapper-->--}}
{{--                            </div>--}}
{{--                            <!--end::Step 5-->--}}
{{--                        </div>--}}
                        <!--end::Nav-->

                        <!--begin::Form-->
                        <form class="form w-lg-700px mx-auto" wire:submit.prevent="submit" novalidate="novalidate" id="kt_stepper_example_basic_form">
                            <!--begin::Group-->
{{--                            <div class="mb-5">--}}
                                <!--begin::Step 1-->
                                @if($currentStep == 1)
                                    <div class="card">
                                        <div class="card-header bg-secondary text-black"><h3 class="card-title">STEP 1/5 - Project</h3></div>
                                        <div class="card-body">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fw-semibold fs-6 mb-2">Project Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" wire:model.defer="project_name" name="project_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Name"/>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fw-semibold fs-6 mb-2">Description</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="textarea" wire:model.defer="description" name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description"/>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Start Date</label>
                                                    <input class="form-control form-control-solid"  wire:model.defer="expected_start_date" placeholder="Pick a date" name="expected_start_date" id="expected_start_date"/>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">End Date</label>
                                                    <input class="form-control form-control-solid"  wire:model.defer="expected_end_date" placeholder="Pick a date" name="expected_end_date" id="expected_end_date"/>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="fw-semibold fs-6 mb-2">Project Size</label>
                                                    <input type="text" wire:model.defer="project_size" name="project_size" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Size"/>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="fw-semibold fs-6 mb-2">Project Type</label>
                                                    <select class="form-select" wire:model.defer="project_type" name="project_type" id="project_type" data-placeholder="Select an option">
                                                        <option>Select an option</option>
                                                        <option value="commercial">Commercial</option>
                                                        <option value="industrial">Industrial</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fw-semibold fs-6 mb-2">Project Manager</label>
                                                <!--end::Label-->
                                                <select class="form-select"  name="project_manager" id="project_manager" data-control="select2" data-placeholder="Select an option">
                                                    <option></option>
                                                    @foreach($users_list as $user)
                                                        <option value="{{$user->id}}"  {{ $project_manager == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fw-semibold fs-6 mb-2">Customers</label>
                                                <!--end::Label-->
                                                <select class="form-select" name="customer" id="customer" data-control="select2" data-placeholder="Select an option">
                                                    <option></option>
                                                    @foreach($customer_list as $customer)
                                                        <option value="{{$customer->id}}" {{ $customer_id == $customer->id ? 'selected' : '' }}>{{$customer->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--end::Input group-->

                                        </div>
                                    </div>
                                @endif
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                @if($currentStep == 2)
                                <div class="card">
                                    <div class="card-header bg-secondary text-black"><h3 class="card-title">STEP 2/5 - Project Milestone</h3></div>
                                    <div class="card-body">
                                        <div class="card m-2">
                                            @foreach($milestone_list as $index => $milestone)
                                            <div class="form-group row m-5">
                                                <div class="fv-row mb-10">
                                                    <label class="required fw-semibold fs-6 mb-2">Project Milestone</label>
                                                    <input type="text" name="project_milestone" wire:model="project_milestone.{{$index}}"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Milestone"/>
                                                </div>
                                                <div class="fv-row mb-10">
                                                    <label class="required fw-semibold fs-6 mb-2">Milestone Description</label>
                                                    <textarea name="milestone_description" wire:model.defer="milestone_description.{{$index}}" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Milestone Description"> </textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-5">
                                                <div class="col-md-12 text-center">
                                                   <button class="btn btn-danger" wire:click.prevent="removeMilestone({{$index}})"> Delete</button>
                                                   <button class="btn btn-primary" wire:click.prevent="addMilestone"> Add</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!--end::Step 2-->

                                <!--begin::Step 3-->
                                @if($currentStep == 3)
                                <div class="card">
                                    <div class="card-header bg-secondary text-black"><h3 class="card-title">STEP 3/5 - Quotation</h3></div>
                                    <div class="card-body">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Prepared Date</label>
                                            <input class="form-control form-control-solid"  wire:model.defer="prepared_date" placeholder="Pick a date" name="prepared_date" id="prepared_date"/>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Assembly Type</label>
                                            <input type="textarea" wire:model.defer="assembly_type" name="assembly_type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Assembly Type"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Manufacturer</label>
                                            <input type="text" wire:model.defer="manufacturer" name="manufacturer" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Manufacturer"/>
                                        </div>
                                        {{-- <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Assembly Type</label>
                                            <input type="textarea" wire:model.defer="assembly_type" name="assembly_type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Assembly Type"/>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">SQ Walls</label>
                                            <input type="text" wire:model.defer="sq_walls" name="sq_walls" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="SQ Walls"/>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">SQ Field</label>
                                            <input type="text" wire:model.defer="sq_field" name="sq_field" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="SQ Field"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Warranty</label>
                                            <input type="text" wire:model.defer="warranty" name="warranty" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Warranty"/>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Parapet Length</label>
                                            <input type="text" wire:model.defer="parapet_length" name="parapet_length" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Parapet Length"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Building Height</label>
                                            <input type="text" wire:model.defer="building_height" name="building_height" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Building Height"/>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Deck Type</label>
                                            <input wire:model.defer="deck_type"  type="text" name="deck_type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Deck Type"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Inclusions</label>
                                            <textarea wire:model.defer="inclusions" name="inclusions"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Inclusions"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Exclusions</label>
                                            <textarea name="exclusions" wire:model.defer="exclusions" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Exclusions"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Payment Schedule</label>
                                            <textarea name="payment_schedule" wire:model.defer="payment_schedule" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Payment Schedule"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Price Escalation Clause</label>
                                            <textarea name="price_escalation_clause" wire:model.defer="price_escalation_clause"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Price Escalation Clause"> </textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Alterations</label>
                                            <textarea name="alterations" wire:model.defer="alterations"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Alterations"> </textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Compliance</label>
                                            <input type="text" wire:model.defer="compliance" name="compliance" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Compliance"/>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required fw-semibold fs-6 mb-2">Timelines</label>
                                            <input type="text" wire:model.defer="timelines" name="timelines" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Timelines"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-10">
                                            <label class="required fw-semibold fs-6 mb-2">Warranty Clause</label>
                                            <textarea wire:model.defer="warranty_clause" name="warranty_clause" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Warranty Clause"> </textarea>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                                <!--end::Step 3-->

                                <!--begin::Step 4-->
                                @if($currentStep == 4)
                                <div class="card">
                                    <div class="card-header bg-secondary text-black"><h3 class="card-title">STEP 4/5 - Quote Line Item</h3></div>
                                    <div class="card-body">
                                        <!--begin::Repeater-->
                                        <div id="quote_line_items">
                                            <!--begin::Form group-->
                                            <div class="form-group">
                                                <div data-repeater-list="quote_line_items">
                                                    <div data-repeater-item>
                                                        @foreach($quoteItems as $index => $quoteLine )
                                                        <div class="card m-2">

                                                            <!--begin::Input group-->
                                                            <div class="fv-row m-5" >
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Product</label>
                                                                <!--end::Label-->
                                                                <select wire:model="products.{{$index}}" class="form-select" name="product" data-placeholder="Select an option">
                                                                    <option></option>
                                                                    @foreach($products_list as $product)
                                                                        <option value="{{$product->id}}"  data-unitprice="{{$product->price}}">{{$product->product_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <!--end::Input group-->
                                                            <div class="form-group row m-5">
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Unit Price</label>
                                                                    <input wire:model="unit_price.{{$index}}" type="text" name="unit_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Unit Price"/>
                                                                </div>
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="fw-semibold fs-6 mb-2">Discount Price (On Total Price)</label>
                                                                    <input wire:model.defer="discount_price.{{$index}}" type="text" name="discount_price" onkeyup="changeDiscountEvent(this)" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Discount Price"/>
                                                                </div>

                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Quantity</label>
                                                                    <input wire:model="quantity.{{$index}}" type="text" name="quantity" onkeyup="changeQuantityEvent(this)" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Quantity"/>
                                                                </div>

                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Total Price</label>
                                                                    <input wire:model.defer="total_price.{{$index}}" type="text" name="total_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Total Price"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-5">
                                                                <div class="col-md-12 text-center">
                                                                    <button class="btn btn-danger" wire:click.prevent="removeQuoteline({{$index}})"> Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                {{-- @foreach($quoteItems as $line_item)
                                                    <span>{{ print_r($line_item, true) }}</span>
                                                @endforeach --}}
                                            </div>
                                            <!--end::Form group-->



                                            <!--begin::Form group-->
                                            <div class="form-group">
                                                <button class="btn btn-primary" wire:click.prevent="addQuoteline"> Add</button>
                                            </div>
                                            <!--end::Form group-->
                                        </div>
                                        <!--end::Repeater-->
                                        {{-- @foreach($quoteItems as $index => $item)
                                            <div class="row" wire:key="{{ $index }}">
                                                <div class="col-md-4 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Product</label>
                                                    <input type="text" wire:model.defer="quoteItems.{{ $index }}.product" name="product" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Product"/>
                                                </div>
                                                <div class="col-md-2 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Price</label>
                                                    <input type="text" wire:model.defer="quoteItems.{{ $index }}.price" name="price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Price"/>
                                                </div>
                                                <div class="col-md-2 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Quantity</label>
                                                    <input type="text" wire:model.defer="quoteItems.{{ $index }}.quantity" name="quantity" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Quantity"/>
                                                </div>
                                                <div class="col-md-2 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Total</label>
                                                    <input type="text" wire:model.defer="quoteItems.{{ $index }}.total" name="total" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Total" readonly/>
                                                </div>
                                                <div class="col-md-2 mb-4">
                                                    <button wire:click.prevent="removeLineItem({{ $index }})" class="btn btn-danger">-</button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-md-2 mb-4">
                                                <button wire:click.prevent="addLineItem" class="btn btn-primary">+</button>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                @endif
                                <!--end::Step 4-->

                                <!--begin::Step 5-->
                                @if($currentStep == 5)
                                <div class="card">
                                    <div class="card-header bg-secondary text-black"><h3 class="card-title">STEP 5/5 - Final Quotation</h3></div>
                                    <div class="card-body">
                                        <div class="fv-row mb-10">
                                            <a href="{{ asset('storage/app/public') }}" download="proposal.pdf">Download Proposal</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!--end::Step 5-->

                            <!--begin::Actions-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Wrapper-->
                                        @if($currentStep > 1)
                                        <div class="me-2">
                                            <button type="button" class="btn btn-light btn-active-light-primary"  wire:click.prevent="decreaseStep">
                                                Back
                                            </button>
                                        </div>
                                        @endif
                                        <!--end::Wrapper-->

                                        <!--begin::Wrapper-->
                                        <div id="wrapper_section">
                                            @if($currentStep == 4)
                                            <button type="submit" class="btn btn-primary" data-kt-quotation-modal-action="submit">
                                                <span class="indicator-label" wire:loading.remove>Submit & Continue</span>
                                                <span class="indicator-progress" wire:loading wire:target="submit">
                                                 Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                            @endif
                                    @if($currentStep < 4)
                                        <button type="button" wire:click="" class="btn btn-primary" data-kt-stepper-action="next" id="continue_next" wire:click.prevent="increaseStep">
                                            Continue
                                        </button>
                                            @endif

                                            <button type="button" class="btn btn-primary" id="continue_next_final" style="display: none" wire:click.prevent="getProposalChatGPT()">
                                                Continue</button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
{{--                            </div>--}}
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
                onReady: function () {
                },
                dateFormat: "Y-m-d",
            });

            $("#expected_end_date").flatpickr({
                onReady: function () {
                },
                dateFormat: "Y-m-d",
            });


            $("#prepared_date").flatpickr({
                onReady: function () {
                },
                dateFormat: "Y-m-d",
            });

            $('#customer').on('change',function (e){
                var data = $('#customer').select2('val')
            @this.set('customer_id',data)
            });

            $('#project_manager').on('change',function (e){
                var data = $('#project_manager').select2('val')
            @this.set('project_manager',data)
            });

        // function changeProductEvent(element){
        //     // console.log($(element));
        //     // console.log($(element).attr('class'));
        //     // console.log($(element).attr('id'));
        //     console.log($(element).attr('name'));
        //     var curr_elem_name = $(element).attr('name');
        //     var curr_index = curr_elem_name.replace("quote_line_items[","").replace("][product]","");//quote_line_items[0][product]
        //     console.log(curr_index);
        //     var selected = $(element).find('option:selected');
        //     console.log(selected.data("unitprice"));
        //
        //     $('input[name="quote_line_items['+curr_index+'][unit_price]"]').val(selected.data("unitprice"));
        //     // $('input[name="quote_line_items['+curr_index+'][total_price]"]').val(selected.data("unitprice"));
        //     $('input[name="quote_line_items['+curr_index+'][discount_price]"]').val(0);
        //     $('input[name="quote_line_items['+curr_index+'][quantity]"]').val(1);//.trigger("change");
        //     // $('input[name="quote_line_items['+curr_index+'][quantity]"]').trigger("change");
        //     setTotalPrice(curr_index);
        //
        // }
        // function changeDiscountEvent(element){
        //     var discount = $(element).val();
        //     // if(discount === "" || discount ==="undefined"){
        //     //     $(element).val(0);
        //     // }
        //     var curr_elem_name = $(element).attr('name');
        //     console.log(curr_elem_name);
        //     var curr_index = curr_elem_name.replace("quote_line_items[","").replace("][discount_price]","");//quote_line_items[0][discount_price]
        //     setTotalPrice(curr_index);
        // }
        //
        // function changeQuantityEvent(element){
        //
        //     var quantity = $(element).val();
        //     // if(quantity === "" || quantity ==="undefined"){
        //     //     $(element).val(0);
        //     // }
        //     // console.log($(element).attr('name'));
        //     var curr_elem_name = $(element).attr('name');
        //     var curr_index = curr_elem_name.replace("quote_line_items[","").replace("][quantity]","");//quote_line_items[0][quantity]
        //     console.log(curr_index);
        //
        //     setTotalPrice(curr_index);
        //
        //
        // }
        //
        // function setTotalPrice(curr_index){
        //     console.log("Total price called for "+curr_index);
        //     var quantity = $('input[name="quote_line_items['+curr_index+'][quantity]"]').val();
        //     var unit_price = $('input[name="quote_line_items['+curr_index+'][unit_price]"]').val();
        //     var discount_price = $('input[name="quote_line_items['+curr_index+'][discount_price]"]').val();
        //
        //     if(quantity === "" || quantity ==="undefined"){
        //         quantity = 0;
        //     }
        //
        //     if(discount_price === "" || discount_price ==="undefined"){
        //         discount_price = 0;
        //     }
        //
        //     $('input[name="quote_line_items['+curr_index+'][total_price]"]').val((quantity*unit_price) - discount_price);
        //
        // }
        //
        // $('#quote_line_items').repeater({
        //     initEmpty: false,
        //
        //     defaultValues: {
        //         'text-input': 'foo'
        //     },
        //
        //     show: function () {
        //         $(this).slideDown();
        //
        //         // Re-init select2
        //         $(this).find('[data-kt-repeater="select2"]').select2();
        //
        //         // Re-init flatpickr
        //         $(this).find('[data-kt-repeater="datepicker"]').flatpickr();
        //
        //         // Re-init tagify
        //         // new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
        //     },
        //
        //     hide: function (deleteElement) {
        //         $(this).slideUp(deleteElement);
        //     },
        //
        //     ready: function(){
        //         // Init select2
        //         $('[data-kt-repeater="select2"]').select2();
        //
        //         // Init flatpickr
        //         $('[data-kt-repeater="datepicker"]').flatpickr();
        //
        //         // Init Tagify
        //         // new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
        //     }
        // });
        // // Stepper lement
        // var element = document.querySelector("#kt_stepper_example_clickable");
        //
        // // Initialize Stepper
        // var stepper = new KTStepper(element);
        //
        // // Handle navigation click
        // stepper.on("kt.stepper.click", function (stepper) {
        //     stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
        // });
        //
        // // Handle next step
        // stepper.on("kt.stepper.next", function (stepper) {
        //     stepper.goNext(); // go next step
        // });
        //
        // // Handle previous step
        // stepper.on("kt.stepper.previous", function (stepper) {
        //     stepper.goPrevious(); // go previous step
        // });
        //
        // stepper.on("kt.stepper.changed", function (stepper) {
        //     if (stepper.currentStepIndex === 4) {
        //         $("#continue_next").hide();
        //         $("#continue_next_final").show();
        //     }else{
        //         $("#continue_next").show();
        //         $("#continue_next_final").hide();
        //     }
        // });
        //
        // document.addEventListener("livewire:load", function () {
        //     Livewire.on('dataUpdated', function () {
        //         // Your logic to handle data update
        //         // For example, you may want to stay on the same step
        //         stepper.goTo(4); // Replace 1 with the desired step index
        //         $("#continue_next").hide();
        //     });
        // });
        //
        // document.addEventListener("livewire:load", function () {
        //     // Get the "Generate Doc" button element
        //     var generateDocButton = document.getElementById('generateDocButton');
        //
        //     // Handle click event on the "Generate Doc" button
        //     generateDocButton.addEventListener('click', function (event) {
        //         // Go to the desired step (change the index as needed)
        //         event.preventDefault();
        //         stepper.goLast();
        //         // stepper.goTo(4); // Assuming the index of the step you want to navigate to is 2
        //     });
        // });

        // stepper.on("kt.stepper.changed", function (stepper) {
        //     var lastStepIndex = stepper.totalStepsNumber;
        //     if (stepper.currentStepIndex === 3) {
        //         // Call your function here
        //         getProposal();
        //     }
        // });
        //
        // // Your custom function to be triggered on the last step
        // function getProposal() {
        //      Livewire.emit('get_proposal')
        //      console.log(Livewire.emit)
        // }
    </script>
@endpush
