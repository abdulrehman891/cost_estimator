<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
	<!--begin::Heading-->
	<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
		<!--begin::Title-->
		<h3 class="text-black fw-semibold px-9 mt-10 mb-6">Notifications
		<span class="fs-8 opacity-75 ps-3">{{$total_unread_notifications}} reports</span></h3>
		<!--end::Title-->
		<!--begin::Tabs-->
		<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
			<li class="nav-item">
				<a class="nav-link text-black opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_3">All</a>
			</li>
		</ul>
		<!--end::Tabs-->
	</div>
	<!--end::Heading-->
	<!--begin::Tab content-->
	<div class="tab-content">
		<!--begin::Tab panel-->
		<div class="tab-pane fade show active" id="kt_topbar_notifications_3" role="tabpanel">
			<!--begin::Items-->
			<div class="scroll-y mh-325px my-5 px-8">


				@if($total_unread_notifications>0)
				@foreach($all_unread_notifications as $key => $notification)
					<!--begin::Item-->
					<div class="d-flex flex-stack py-4">
						<!--begin::Section-->
						<div class="d-flex align-items-center me-2">
							<!--begin::Code-->
							@if($notification->data['status_code']==200 || empty($notification->data['status_code']))
								<span class="w-100px badge badge-light-success me-4">200 {{strtoupper($notification->data['status_msg'])}} </span>
							@elseif($notification->data['status_code']==300)
								<span class="w-100px badge badge-light-warning me-4">300 {{strtoupper($notification->data['status_msg'])}}</span>
							@elseif($notification->data['status_code']==500)
								<span class="w-100px badge badge-light-danger me-4">500 {{strtoupper($notification->data['status_msg'])}}</span>
							@endif
							<!--end::Code-->							
							<!--begin::Title-->
							@if(!empty($notification->data['record_module']) && $notification->data['record_module']=='quotation')
								<a class="text-gray-800 text-hover-primary fw-semibold" target="_blank" href="{{ route('quotation.list', ['signnow_document_id' => $notification->data['record_ref_number'], 'record_id' =>$notification->data['record_id']])}}" class="btn btn-link">{{$notification->data['message']}}</a>
							@else
								<a class="text-gray-800 text-hover-primary fw-semibold" href="#" class="btn btn-link">{{$notification->data['message']}}</a>
							@endif
							<!--end::Title-->
						</div>
						<!--end::Section-->
						<!--begin::Label-->
						@php							
							$timeDifferenceInHours = \Carbon\Carbon::now()->diffInHours(\Carbon\Carbon::createFromTimestamp(strtotime($notification->created_at)));
							if($timeDifferenceInHours>0){
								$diff_text="$timeDifferenceInHours hr";
							}else{
								$timeDifferenceInMinutes = \Carbon\Carbon::now()->diffInMinutes(\Carbon\Carbon::createFromTimestamp(strtotime($notification->created_at)));
								if($timeDifferenceInMinutes>5){
									$diff_text="$timeDifferenceInMinutes Min";
								}else{
									$diff_text="Just Now";
								}
							}
						@endphp
						<span class="badge badge-light fs-8">{{$diff_text}}</span>
						<!--end::Label-->
					</div>
					<!--end::Item-->
				@endforeach
				@endif				 				 
			</div>
			<!--end::Items-->
			<!--begin::View more-->
			<div class="py-3 text-center border-top">
				<a href="{{ route('notifications')}}" class="btn btn-color-gray-600 btn-active-color-primary">View All {!! getIcon('arrow-right', 'fs-5') !!}</a>
			</div>
			<!--end::View more-->
		</div>
		<!--end::Tab panel-->
	</div>
	<!--end::Tab content-->
</div>
<!--end::Menu-->
