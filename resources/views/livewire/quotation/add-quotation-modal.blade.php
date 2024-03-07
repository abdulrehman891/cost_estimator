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
                        <!--begin::Form-->
                        <form class="form w-lg-700px mx-auto" wire:submit.prevent="submit" novalidate="novalidate" id="kt_stepper_example_basic_form">
                            <!--begin::Group-->
{{--                            <div class="mb-5">--}}
                                <!--begin::Step 1-->
                                @if($currentStep == 1)
                                    <div class="card">
                                        <div class="card-header bg-primary text-black"><h3 class="card-title text-white">STEP 1/5 - Project</h3></div>
                                        <div class="card-body">
                                            <div class="fv-row mb-10" >
                                                <!--begin::Label-->
                                                <label class="fw-semibold fs-6 mb-2">Projects(Please select if already created)</label>
                                                <!--end::Label-->
                                                <div wire:ignore>
                                                    <select wire:model="projects"  class="form-select" name="projects" id="projects" data-control="select2" data-dropdown-parent="#kt_modal_add_quotation" data-placeholder="Select an option" >
                                                        <option></option>
                                                        @foreach($this->project_list as $project)
                                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
{{--                                                wire:model="projects"--}}
                                            </div>
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fw-semibold fs-6 mb-2">Project Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" wire:model.defer="project_name" name="project_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Name"/>
                                                @error('project_name') <span class="text-danger">{{ $message }}</span> @enderror
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fw-semibold fs-6 mb-2">Description</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="textarea" wire:model.defer="description" name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Description"/>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <div class="fv-row mb-10">
                                                    <label for="image" class="fw-semibold fs-6 mb-2">Image</label>
                                                    <input type="file" wire:model="project_image" accept="image/png,image/jpeg" class="form-control mb-3 mb-lg-0">
                                                    @if($project_image)
                                                    <img class="w-25 p-1" src="{{ asset('storage/'.$project_image) }}" alt="" />
{{--                                                        <img src="data:image/png;base64,{{ $project_image }}" alt="Image">--}}
                                                    @endif
                                            </div>

                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fw-semibold fs-6 mb-2">Address</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="textarea" wire:model.defer="address" name="address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Address"/>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Start Date</label>
                                                    <input class="form-control form-control-solid"  wire:model.defer="expected_start_date" placeholder="Pick a date" name="expected_start_date" id="expected_start_date"/>
                                                    @error('expected_start_date') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">End Date</label>
                                                    <input class="form-control form-control-solid"  wire:model.defer="expected_end_date" placeholder="Pick a date" name="expected_end_date" id="expected_end_date"/>
                                                    @error('expected_end_date') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Project Size</label>
                                                    <input type="text" wire:model.defer="project_size" name="project_size" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Size"/>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="required fw-semibold fs-6 mb-2">Project Type</label>
                                                    <select class="form-select" wire:model.defer="project_type" name="project_type" id="project_type" data-placeholder="Select an option">
                                                        <option>Select an option</option>
                                                        <option value="commercial">Commercial</option>
                                                        <option value="industrial">Industrial</option>
                                                    </select>
                                                    @error('project_type') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <!--begin::Input group-->

                                            <!--end::Input group-->

                                        </div>
                                    </div>
                                @endif
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                @if($currentStep == 2)
                                    <div class="card">
                                        <div class="card-header bg-primary text-black"><h3 class="card-title text-white">STEP 2/5 - Project Milestone</h3></div>
                                        <div class="card-body">
                                            <div class="card m-2">
                                                @foreach($milestone_list as $index => $milestone)
                                                <div class="form-group row m-5">
                                                    <div class="fv-row mb-10">
                                                        <label class="fw-semibold fs-6 mb-2">Project Milestone</label>
                                                        <input type="text" name="project_milestone" wire:model="project_milestone.{{$index}}"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Milestone"/>
                                                    </div>
                                                    <div class="fv-row mb-10">
                                                        <label class="fw-semibold fs-6 mb-2">Milestone Description</label>
    {{--                                                    <input type="textarea" name="project_milestone" wire:model="milestone_description.{{$index}}"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Milestone Description"/>--}}

                                                        <textarea wire:model="milestone_description.{{$index}}" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Milestone Description"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-5">
                                                    <div class="col-md-12 text-center">
                                                        @if(count($milestone_list) != 1 )
                                                            <button class="btn btn-danger" wire:click.prevent="removeMilestone({{$index}})" > Delete</button>
                                                        @endif
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
                                    <div class="card-header bg-primary text-black"><h3 class="card-title text-white">STEP 3/5 - Quotation</h3></div>
                                    <div class="card-body">
                                        <div class="fv-row mb-10" >
                                            <!--begin::Label-->
                                            <label class="fw-semibold fs-6 mb-2">Quotation Template</label>
                                            <!--end::Label-->
{{--                                            <div wire:ignore>--}}
                                                <select wire:model="quotationTemplateID" class="form-select" name="quotationTemplateID" id="quotationTemplateID" data-dropdown-parent="#kt_modal_add_quotation" data-control="select2" data-placeholder="Select an option">
                                                    <option></option>
                                                    @foreach($quote_templates_list as $quote_template)
                                                        <option value="{{$quote_template->id}}">{{$quote_template->name}}</option>
                                                    @endforeach
                                                </select>
{{--                                            </div>--}}
                                        </div>

                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fw-semibold fs-6 mb-2">Customers</label>
                                            <!--end::Label-->
                                            <div wire:ignore>
                                                <select wire:model="customer_id" class="form-select" name="customer" id="customer" data-dropdown-parent="#kt_modal_add_quotation" data-control="select2" data-placeholder="Select an option">
                                                    <option></option>
                                                    @foreach($customer_list as $customers)
                                                        <option value="{{$customers->id}}" {{ $customer_id == $customers->id ? 'selected' : '' }}>{{$customers->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                    <!--begin::Input group-->
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Prepared Date</label>
                                                <input class="form-control form-control-solid"  wire:model.defer="prepared_date" placeholder="Pick a date" name="prepared_date" id="prepared_date"/>
                                                @error('prepared_date') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Assembly Type</label>
                                                <input type="textarea" wire:model.defer="assembly_type" name="assembly_type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Assembly Type"/>
                                                @error('assembly_type') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Manufacturer</label>
                                                <input type="text" wire:model.defer="manufacturer" name="manufacturer" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Manufacturer"/>
                                                @error('manufacturer') <span class="text-danger">{{ $message }}</span> @enderror
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
                                                @error('sq_walls') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">SQ Field</label>
                                                <input type="text" wire:model.defer="sq_field" name="sq_field" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="SQ Field"/>
                                                @error('sq_field') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Warranty</label>
                                                <input type="text" wire:model.defer="warranty" name="warranty" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Warranty"/>
                                                @error('warranty') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Parapet Length</label>
                                                <input type="text" wire:model.defer="parapet_length" name="parapet_length" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Parapet Length"/>
                                                @error('parapet_length') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Building Height</label>
                                                <input type="text" wire:model.defer="building_height" name="building_height" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Building Height"/>
                                                @error('building_height') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Deck Type</label>
                                                <input wire:model.defer="deck_type"  type="text" name="deck_type" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Deck Type"/>
                                                @error('deck_type') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Inclusions</label>
                                                <textarea wire:model.defer="inclusions" name="inclusions"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Inclusions"> </textarea>
                                                @error('inclusions') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Exclusions</label>
                                                <textarea name="exclusions" wire:model.defer="exclusions" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Exclusions"> </textarea>
                                                @error('exclusions') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Payment Schedule</label>
                                                <textarea name="payment_schedule" wire:model.defer="payment_schedule" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Payment Schedule"> </textarea>
                                                @error('payment_schedule') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Price Escalation Clause</label>
                                                <textarea name="price_escalation_clause" wire:model.defer="price_escalation_clause"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Price Escalation Clause"> </textarea>
                                                @error('price_escalation_clause') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label class="required fw-semibold fs-6 mb-2">Alterations</label>
                                                <textarea name="alterations" wire:model.defer="alterations"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Alterations"> </textarea>
                                                @error('alterations') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-10">
                                                <label class="required fw-semibold fs-6 mb-2">Compliance</label>
                                                <textarea name="compliance" wire:model.defer="compliance"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Compliance"> </textarea>
                                                @error('compliance') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-10">
                                                    <label class="required fw-semibold fs-6 mb-2">Timelines</label>
                                                    <textarea name="timelines" wire:model.defer="timelines"  class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Timelines"> </textarea>
                                                    @error('timelines') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-10">
                                                <label class="required fw-semibold fs-6 mb-2">Warranty Clause</label>
                                                <textarea wire:model.defer="warranty_clause" name="warranty_clause" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Warranty Clause"> </textarea>
                                                @error('warranty_clause') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $("#prepared_date").flatpickr({
                                            onReady: function () {
                                            },
                                            dateFormat: "Y-m-d",
                                        });

                                        $('#quotationTemplateID').select2();
                                        $('#quotationTemplateID').on('change',function (e){
                                            var data = $('#quotationTemplateID').select2('val')
                                        @this.set('quotationTemplateID',data);
                                        });

                                        $('#customer').select2();
                                        $('#customer').on('change',function (e){
                                            var data = $('#customer').select2('val')
                                        @this.set('customer_id',data)
                                        });


                                    </script>
                                </div>

                                @endif
                                <!--end::Step 3-->

                                <!--begin::Step 4-->
                                @if($currentStep == 4)
                                <div class="card">
                                    <div class="card-header bg-primary text-black"><h3 class="card-title text-white">STEP 4/5 - Quote Line Item</h3></div>
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
                                                                @if(count($this->project_milestone) > 0)
                                                                    <label class="required fw-semibold fs-6 mb-2">Project Milestones</label>
                                                                    <select wire:model="milestone_quote.{{$index}}" class="form-select" name="milestone_quote" id="milestone_quote" data-placeholder="Select an option">
                                                                        <option>--Please Select--</option>
                                                                        @for($x = 0; $x < count($this->project_milestone); $x++)
                                                                            <option value="{{ $project_milestone[$x] }}" >{{ $project_milestone[$x] }}</option>
                                                                        @endfor
                                                                    </select>
                                                                @endif
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Product</label>
                                                                <!--end::Label-->
                                                                <select wire:model="products.{{$index}}" class="form-select" name="product" id="product" data-placeholder="Select an option">
                                                                    <option></option>
                                                                    @foreach($products_list as $product)
                                                                        <option value="{{$product->id}}"  data-unitprice="{{$product->price}}">{{$product->product_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('products.'.$index) <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                            <!--end::Input group-->
                                                            <div class="form-group row m-5">
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Unit Price</label>
                                                                    <input wire:model="unit_price.{{$index}}" type="text" name="unit_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Unit Price"/>
                                                                    @error('unit_price.'.$index) <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                                <div class="col-md-6 mb-4">
                                                                    <label class="fw-semibold fs-6 mb-2">Discount Price (On Total Price)</label>
                                                                    <input wire:model="discount_price.{{$index}}" type="text" name="discount_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Discount Price"/>
                                                                </div>

                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Quantity</label>
                                                                    <input wire:model="quantity.{{$index}}" type="text" name="quantity" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Quantity"/>
                                                                    @error('quantity.'.$index) <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>

                                                                <div class="col-md-6 mb-4">
                                                                    <label class="required fw-semibold fs-6 mb-2">Total Price</label>
                                                                    <input wire:model.defer="total_price.{{$index}}" type="text" name="total_price" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Total Price" readonly/>
                                                                    @error('total_price.'.$index) <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mb-5">
                                                                <div class="col-md-12 text-center">
                                                                    <label class="checkbox checkbox-lg">
                                                                        <input wire:model.defer="price_update.{{$index}}" type="checkbox" name="Checkboxes3_1">
                                                                        <span></span>
                                                                        Update Price
                                                                        </label>
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
                                    </div>
                                </div>
                                @endif
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                @if($currentStep == 5)
                                <div class="card">
                                    <div class="card-header bg-primary text-black"><h3 class="card-title text-white">STEP 5/5 - Final Quotation</h3></div>
                                    <div class="card-body">
                                        <div class="fv-row mb-10">
                                        <textarea id="proposal_preview" name="proposal_preview" style="display: none">
                                           {!! nl2br($chatGPT_res) !!}
                                        </textarea>
                                            <button type="button" class="btn btn-primary" wire:click="previewProposal" wire:loading.attr="disabled">
                                                <span class="indicator-label" wire:loading.remove>Preview</span>
                                                <span class="indicator-progress" wire:loading wire:target="previewProposal">
                                                     Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                            </button>
                                            @if($preview == true)
                                                <button type="button" class="btn btn-primary"  wire:click="regenerateProposal" wire:loading.attr="disabled">
                                                    <span class="indicator-label" wire:loading.remove>Regenerate</span>
                                                    <span class="indicator-progress" wire:loading wire:target="regenerateProposal">
                                                     Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <script>

                                    $('html').find('script').filter(function(){
                                        return $(this).attr('src') === 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.1.1/tinymce.min.js'
                                    }).remove();

                                    window.livewire.on('responseGenerated',() => {
                                        $("textarea#proposal_preview").show();
                                                var url = "https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.1.1/tinymce.min.js";
                                                $.getScript(url, function () {
                                                    //$("textarea#proposal_preview").show();
                                                    tinymce.remove('textarea#proposal_preview');
                                                    tinymce.execCommand('mceRemoveControl', true, 'proposal_preview');
                                                    tinymce.remove();
                                                    $('div.tox-tinymce').remove();
                                                    setTimeout(function() {
                                                        tinymce.init({
                                                            selector: 'textarea#proposal_preview',
                                                            setup: function (editor) {
                                                                editor.on('init change', function () {
                                                                    editor.save();
                                                                });
                                                                editor.on('change', function (e) {
                                                                    var data = $('#proposal_preview').val();
                                                                @this.set('chatGPT_res', data);
                                                                });
                                                            }
                                                        });
                                                    }, 200);
                                                });
                                    });
                                </script>
                                @endif
                                <!--end::Step 5-->
                                <!--begin::Actions-->
                                    <div class="mt-4 d-flex flex-stack">
                                        <!--begin::Wrapper-->
                                        @if($currentStep > 1)
                                        <div class="me-2">
                                            <button type="button" class="btn btn-light btn-active-light-primary" wire:click.prevent="decreaseStep" >
                                                Back
                                            </button>
                                        </div>
                                        @endif
                                        <!--end::Wrapper-->

                                        <!--begin::Wrapper-->
                                        <div id="wrapper_section">
                                            @if($currentStep == 5)
                                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"  data-kt-quotation-modal-action="submit">
                                                    <span class="indicator-label" wire:loading.remove>Submit & Generate</span>
                                                    <span class="indicator-progress" wire:loading wire:target="submit" >
                                                     Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            @endif
                                            @if($currentStep < 5)
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

{{--@push('scripts')--}}
    <script>

        document.addEventListener('livewire:load', function () {

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



            $('#projects').select2();
            $('#projects').on('change',function (e){
                var data = $('#projects').select2('val')
            @this.set('projects',data)
            });
        })

    </script>
{{--@endpush--}}
