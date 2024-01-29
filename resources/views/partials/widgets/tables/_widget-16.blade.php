<!--begin::Tables widget 16-->
<div class="card card-flush h-xl-100">
	<!--begin::Header-->
	<div class="card-header pt-5">
		<!--begin::Title-->
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold text-gray-800">Won Quotes</span>
			<span class="text-gray-500 mt-1 fw-semibold fs-6">Avg. {{$completed_percentage}}% Won. Rate</span>
		</h3>
		<!--end::Title-->		 
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body pt-6">
		<!--begin::Nav-->
		<ul class="nav nav-pills nav-pills-custom mb-3">
			<!--begin::Item-->
			<li class="nav-item mb-3 me-3 me-lg-6">
				<!--begin::Link-->
				<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 active" id="kt_stats_widget_16_tab_link_1" data-bs-toggle="pill" href="#kt_stats_widget_16_tab_1">
					<!--begin::Icon-->
					<div class="nav-icon mb-3">{!! getIcon('shop', 'fs-1') !!}</div>
					<!--end::Icon-->
					<!--begin::Title-->
					<span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Commercial</span>
					<!--end::Title-->
					<!--begin::Bullet-->
					<span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
					<!--end::Bullet-->
				</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-3 me-3 me-lg-6">
				<!--begin::Link-->
				<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2" id="kt_stats_widget_16_tab_link_2" data-bs-toggle="pill" href="#kt_stats_widget_16_tab_2">
					<!--begin::Icon-->
					<div class="nav-icon mb-3">{!! getIcon('joystick', 'fs-1') !!}</div>
					<!--end::Icon-->
					<!--begin::Title-->
					<span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Industrial</span>
					<!--end::Title-->
					<!--begin::Bullet-->
					<span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
					<!--end::Bullet-->
				</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
			<!--begin::Item-->
			<li class="nav-item mb-3 me-3 me-lg-6">
				<!--begin::Link-->
				<a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2" id="kt_stats_widget_16_tab_link_3" data-bs-toggle="pill" href="#kt_stats_widget_16_tab_3">
					<!--begin::Icon-->
					<div class="nav-icon mb-3">{!! getIcon('home', 'fs-1') !!}</div>
					<!--end::Icon-->
					<!--begin::Title-->
					<span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Residential</span>
					<!--end::Title-->
					<!--begin::Bullet-->
					<span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
					<!--end::Bullet-->
				</a>
				<!--end::Link-->
			</li>
			<!--end::Item-->
		</ul>
		<!--end::Nav-->
		<!--begin::Tab Content-->
		<div class="tab-content">
			<!--begin::Tap pane-->
			<div class="tab-pane fade show active" id="kt_stats_widget_16_tab_1">
				<!--begin::Table container-->
				<div class="table-responsive">
					<!--begin::Table-->
					<table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
						<!--begin::Table head-->
						<thead>
							<tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
								<th class="p-0 pb-3 min-w-150px text-start">Customer</th>
								<th class="p-0 pb-3 min-w-100px pe-13">Project Name</th>
								<th class="p-0 pb-3 w-125px pe-7">Prepared Date</th>
								<th class="p-0 pb-3 w-50px text-end">VIEW</th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							@foreach($completed_quotes_by_type['commercial'] AS $quote_data)
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div class="symbol symbol-50px me-3">
													<img src="{{ image('avatars/blank.png') }}" class="" alt="" />
												</div>
												<div class="d-flex justify-content-start flex-column">
													<a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$quote_data['customer_name']}}</a>
													{{-- <span class="text-gray-500 fw-semibold d-block fs-7">Haiti</span> --}}
												</div>
											</div>
										</td>
										<td class="pe-13">
											<span class="text-gray-600 fw-bold fs-6">{{$quote_data['project_name']}}</span>
										</td>
										<td class="pe-0">
											{{$quote_data['prepared_date']}}
										</td>
										<td class="text-end">
											<a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">{!! getIcon('black-right', 'fs-2 text-gray-500') !!}</a>
										</td>
									</tr>
							@endforeach
						</tbody>
						<!--end::Table body-->
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
			<!--begin::Tap pane-->
			<div class="tab-pane fade" id="kt_stats_widget_16_tab_2">
				<!--begin::Table container-->
				<div class="table-responsive">
					<!--begin::Table-->
					<table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
						<!--begin::Table head-->
						<thead>
							<tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
								<th class="p-0 pb-3 min-w-150px text-start">Customer</th>
								<th class="p-0 pb-3 min-w-100px pe-13">Project Name</th>
								<th class="p-0 pb-3 w-125px pe-7">Prepared Date</th>
								<th class="p-0 pb-3 w-50px text-end">VIEW</th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							@foreach($completed_quotes_by_type['industrial'] AS $quote_data)
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div class="symbol symbol-50px me-3">
													<img src="{{ image('avatars/blank.png') }}" class="" alt="" />
												</div>
												<div class="d-flex justify-content-start flex-column">
													<a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$quote_data['customer_name']}}</a>
													{{-- <span class="text-gray-500 fw-semibold d-block fs-7">Haiti</span> --}}
												</div>
											</div>
										</td>
										<td class="pe-13">
											<span class="text-gray-600 fw-bold fs-6">{{$quote_data['project_name']}}</span>
										</td>
										<td class="pe-0">
											{{$quote_data['prepared_date']}}
										</td>
										<td class="text-end">
											<a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">{!! getIcon('black-right', 'fs-2 text-gray-500') !!}</a>
										</td>
									</tr>
							@endforeach
						</tbody>
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
			<!--begin::Tap pane-->
			<div class="tab-pane fade" id="kt_stats_widget_16_tab_3">
				<!--begin::Table container-->
				<div class="table-responsive">
					<!--begin::Table-->
					<table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
						<!--begin::Table head-->
						<thead>
							<tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
								<th class="p-0 pb-3 min-w-150px text-start">Customer</th>
								<th class="p-0 pb-3 min-w-100px pe-13">Project Name</th>
								<th class="p-0 pb-3 w-125px pe-7">Prepared Date</th>
								<th class="p-0 pb-3 w-50px text-end">VIEW</th>
							</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
							@foreach($completed_quotes_by_type['residential'] AS $quote_data)
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div class="symbol symbol-50px me-3">
													<img src="{{ image('avatars/blank.png') }}" class="" alt="" />
												</div>
												<div class="d-flex justify-content-start flex-column">
													<a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$quote_data['customer_name']}}</a>
													{{-- <span class="text-gray-500 fw-semibold d-block fs-7">Haiti</span> --}}
												</div>
											</div>
										</td>
										<td class="pe-13">
											<span class="text-gray-600 fw-bold fs-6">{{$quote_data['project_name']}}</span>
										</td>
										<td class="pe-0">
											{{$quote_data['prepared_date']}}
										</td>
										<td class="text-end">
											<a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">{!! getIcon('black-right', 'fs-2 text-gray-500') !!}</a>
										</td>
									</tr>
							@endforeach
						</tbody>
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--end::Tap pane-->
			<!--end::Table container-->
		</div>
		<!--end::Tab Content-->
	</div>
	<!--end: Card Body-->
</div>
<!--end::Tables widget 16-->
