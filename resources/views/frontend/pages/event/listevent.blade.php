@extends('layouts.appfrontend')

@section('content')
@php
$selectedFilters = $selectedFilters ?? [
'category' => [],
'level' => [],
'instructor' => [],
];
@endphp
<div id="content-area">
	<div class="row">
		<div class="col-sm-12 ui-resizable" data-type="container-content">
			<div data-type="component-text">
				<div>
					<div class="breadcrumb_area"
						style="background-image: url('frontend/infixlmstheme/img/new_bread_crumb_bg.png')">
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									<div class="breadcam_wrap">
										<h3>
											Join the Millions for better learning experience
										</h3>
										<p>
											Home / Courses
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="full-page" data-type="component-text"
				data-preview="https://infixlms.ischooll.com/frontend/infixlmstheme/img/snippets/preview/class/all_class_page_section.jpg"
				data-aoraeditor-title="All Course Page Section" data-aoraeditor-categories="Course Page">

				<div class="row">
					<div class="col-sm-12 ui-resizable" data-type="container-content">

					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 ui-resizable" data-type="container-content">
						<div data-type="component-text"
							data-preview="https://infixlms.ischooll.com/frontend/infixlmstheme/img/snippets/preview/class/class_page_section.jpg"
							data-aoraeditor-title="Course Page Section"
							data-aoraeditor-categories="Course Page">

							<input type="hidden" class="class_route" name="class_route" value="courses.html">
							<div class="courses_area">
								<div class="container">
									<div class="row">
										<div class="col-lg-4 col-xl-3">
											<div class="course_category_chose  mt_10">
												<div class="course_title d-flex align-items-center">

													<div class="popupClose"><i class="ti-close"></i></div>
												</div>

												<form id="class-filter-form" action="{{ url('/list-class') }}" method="GET">
													<div class="course_category_inner">
														<div class="single_course_categry">
															<h4 class="font_18 f_w_700">
																Kategori
															</h4>

															<div data-type="component-nonExisting">
																@foreach($pencarian['category'] as $ktg)
																<div class="dynamicData">
																	<ul class="Check_sidebar">
																		<li>
																			<label class="primary_checkbox d-flex">
																				<input type="checkbox" name="category[]" value="{{$ktg}}"
																					class="category class-filter-checkbox"
																					{{ in_array($ktg, $selectedFilters['category'] ?? []) ? 'checked' : '' }}>
																				<span
																					class="checkmark mr_15"></span>
																				<span
																					class="label_name">{{$ktg}}</span>
																			</label>
																		</li>
																	</ul>
																</div>
																@endforeach

															</div>
														</div>
														<div class="single_course_categry">
															<h4 class="font_18 f_w_700">
																Level
															</h4>
															<div data-type="component-nonExisting">
																<div class="dynamicData">
																	<ul class="Check_sidebar">
																		@foreach($pencarian['level'] as $lvl)
																		@php
																		$level = '';
																		if($lvl == 1){
																		$level = 'Pemula';
																		}
																		if($lvl == 2){
																		$level = 'Menengah';
																		}
																		if($lvl == 3){
																		$level = 'Lanjutan';
																		}
																		@endphp
																		<li>
																			<label class="primary_checkbox d-flex">
																				<input name="level[]" type="checkbox"
																					value="{{$lvl}}" class="level class-filter-checkbox"
																					{{ in_array((string) $lvl, array_map('strval', $selectedFilters['level'] ?? [])) ? 'checked' : '' }}>
																				<span
																					class="checkmark mr_15"></span>
																				<span class="label_name">{{$level}}</span>
																			</label>
																		</li>
																		@endforeach
																	</ul>
																</div>
															</div>


														</div>
														<!-- <div class="single_course_categry">
														<h4 class="font_18 f_w_700">
															Price
														</h4>
														<div data-type="component-nonExisting" data-preview=""
															data-table="" data-select="" data-order=""
															data-limit="" data-view="_single_sidebar_price"
															data-model="" data-with="">
															<div class="dynamicData"
																data-dynamic-href="get-dynamic-data.html">
																<ul class="Check_sidebar">
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox" class="price"
																				value="paid">
																			<span
																				class="checkmark mr_15"></span>
																			<span class="label_name">Paid</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox" class="price"
																				value="free">
																			<span
																				class="checkmark mr_15"></span>
																			<span class="label_name">Free</span>
																		</label>
																	</li>
																</ul>
															</div>
														</div>
													</div> -->
														<!-- <div class="single_course_categry">
														<h4 class="font_18 f_w_700">
															Language
														</h4>
														<div data-type="component-nonExisting" data-preview=""
															data-table="languages" data-select="id,name"
															data-order="" data-limit="" data-where-status="1"
															data-view="_single_sidebar_language" data-model=""
															data-with="">
															<div class="dynamicData"
																data-dynamic-href="get-dynamic-data.html">
																<ul class="Check_sidebar">
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="111">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Vietnamese</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="105">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Turkish</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="83">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Russian</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="79">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Portuguese</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="41">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Italian</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="28">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">French</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="20">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Spanish</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="19">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">English</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="15">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">German</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="9">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Bengali</span>
																		</label>
																	</li>
																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="language" value="3">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name">Arabic</span>
																		</label>
																	</li>

																</ul>
															</div>
														</div>
													</div> -->

														<div class="single_course_categry">
															<h4 class="font_18 f_w_700">
																Instructors
															</h4>
															<div data-type="component-nonExisting">
																<div class="dynamicData">
																	<ul class="Check_sidebar">
																		@foreach($pencarian['instructor'] as $key => $val)
																		<li>
																			<label class="primary_checkbox d-flex">
																				<input type="checkbox" name="instructor[]"
																					class="instructor class-filter-checkbox" value="{{$val}}"
																					{{ in_array((string) $val, array_map('strval', $selectedFilters['instructor'] ?? [])) ? 'checked' : '' }}>
																				<span
																					class="checkmark mr_15"></span>
																				<span class="label_name">{{$key}}</span>
																			</label>
																		</li>
																		@endforeach
																	</ul>
																</div>
															</div>
														</div>
														<!-- <div class="single_course_categry">
														<h4 class="font_18 f_w_700">
															Rating
														</h4>
														<div data-type="component-nonExisting" data-preview=""
															data-table="" data-select="" data-order=""
															data-limit="" data-where-status="1"
															data-view="_single_sidebar_rating" data-model=""
															data-with="course">
															<div class="dynamicData"
																data-dynamic-href="get-dynamic-data.html">
																<ul class="Check_sidebar">

																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="rating" value="5">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name d-flex align-items-center gap-12 rating_filter_star">
																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																			</span>
																		</label>
																	</li>

																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="rating" value="4">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name d-flex align-items-center gap-12 rating_filter_star">
																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>



																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>


																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>
																			</span>
																		</label>
																	</li>

																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="rating" value="3">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name d-flex align-items-center gap-12 rating_filter_star">
																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>
																			</span>
																		</label>
																	</li>

																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="rating" value="2">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name d-flex align-items-center gap-12 rating_filter_star">
																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>


																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>


																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>
																			</span>
																		</label>
																	</li>

																	<li>
																		<label class="primary_checkbox d-flex">
																			<input type="checkbox"
																				class="rating" value="1">
																			<span
																				class="checkmark mr_15"></span>
																			<span
																				class="label_name d-flex align-items-center gap-12 rating_filter_star">
																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z"
																						fill="url(#paint0_linear_2618_3008)" />
																					<defs>
																						<linearGradient
																							id="paint0_linear_2618_3008"
																							x1="1.55139"
																							y1="11.5344"
																							x2="16.3193"
																							y2="8.1671"
																							gradientUnits="userSpaceOnUse">
																							<stop
																								stop-color="var(--system_primery_gredient1, #660AFB)" />
																							<stop offset="1"
																								stop-color="var(--system_primery_gredient2, #BF37FF)" />
																						</linearGradient>
																					</defs>
																				</svg>

																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>


																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>


																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>


																				<svg width="18" height="18"
																					viewBox="0 0 18 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z"
																						fill="var(--system_primery_gredient1)"
																						fill-opacity="0.3" />
																				</svg>

																			</span>
																		</label>
																	</li>

																</ul>
															</div>
														</div>
																			</div> -->
														@if(count(array_filter($selectedFilters)) > 0)
														<a href="{{ url('/list-class') }}" class="theme_btn small_btn w-100 text-center mt_20">Reset Filter</a>
														@endif
													</div>
												</form>

											</div>
										</div>
										<div class="col-lg-8 col-xl-9">
											<div data-type="component-nonExisting">
												<div class="dynamicData">
													<div id="class-list" class="row row-gap-24">

														<div class="col-12">
															<div
																class="box_header d-flex flex-wrap align-items-center justify-content-between">
																<h5 class="font_16 f_w_500 mb-0">{{ $class->total() }}
																	Kelas
																</h5>
																<div class="box_header_right">
																	<div
																		class="short_select d-flex align-items-center">
																		<div class="mobile_filter mr_10">
																			<svg xmlns="http://www.w3.org/2000/svg"
																				width="19.5" height="13"
																				viewBox="0 0 19.5 13">
																				<g transform="translate(28)">
																					<rect id=""
																						data-name="Rectangle 1"
																						width="19.5" height="2"
																						rx="1"
																						transform="translate(-28)"
																						fill="var(--system_primery_color)" />
																					<rect id=""
																						data-name="Rectangle 2"
																						width="15.5" height="2"
																						rx="1"
																						transform="translate(-26 5.5)"
																						fill="var(--system_primery_color)" />
																					<rect id=""
																						data-name="Rectangle 3"
																						width="5" height="2"
																						rx="1"
																						transform="translate(-20.75 11)"
																						fill="var(--system_primery_color)" />
																				</g>
																			</svg>
																		</div>

																		<!-- <select class="small_select" id="order">
																			<option value="" data-display="">
																				None</option>
																			<option value="price">Price</option>
																			<option value="created_at">Date
																			</option>
																		</select> -->
																	</div>
																</div>
															</div>
														</div>
														@if($class->isEmpty())
														<div class="col-12">
															<div class="text-center bg-white border rounded p-5">
																<h4 class="font_20 f_w_700 mb_10">Kelas tidak ditemukan</h4>
																<p class="mb_20">Belum ada kelas yang sesuai dengan filter yang dipilih.</p>
																@if(count(array_filter($selectedFilters)) > 0)
																<a href="{{ url('/list-class') }}" class="theme_btn small_btn">Reset Filter</a>
																@endif
															</div>
														</div>
														@endif
														@include('frontend.partials.class-items', ['class' => $class])
														@php $renderedClassItems = $class; $class = collect(); @endphp
														@foreach($class as $key => $value)
														@php
														$level = '';
														$realprice = 0;
														$afterpromo = 0;
														if($value->level == 1){
														$level = 'Pemula';
														}
														if($value->level == 2){
														$level = 'Menengah';
														}
														if($value->level == 3){
														$level = 'Lanjutan';
														}

														if($value->pricing != null){
														$realprice = $value->pricing->price;
														$afterpromo = $value->pricing->promo_price;
														}

														@endphp
														<div class="col-sm-6 col-xl-4">
															<div class="course-item">
																<a
																	href="#">
																	<div class="course-item-img lazy">
																		<img src="{{$value->image_mobile}}"
																			alt="">

																		<span class="course-tag">
																			<span>
																				{{$level}}
																			</span>
																		</span>
																	</div>
																</a>
																<div class="course-item-info">
																	<a href="#"
																		class="title"
																		title="Ethical Hacking Course">
																		{{$value->title}}
																	</a>
																	<div
																		class="d-flex align-itemes-center justify-content-between meta">
																		<div class="rating">
																			<svg width="16" height="15"
																				viewBox="0 0 16 15" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
																					fill="#FFC107" />
																			</svg>
																			<span>0 (0 Rating)</span>
																		</div>
																		<div class="enrolled-student">
																			<a href="#">
																				<svg width="16" height="18"
																					viewBox="0 0 16 18"
																					fill="none"
																					xmlns="http://www.w3.org/2000/svg">
																					<path
																						d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
																						fill="#292D32" />
																				</svg>
																				Limit {{$value->participant_limit}} Orang
																			</a>
																		</div>
																	</div>

																	<div class="course-item-info-description">
																		{!! $value->content !!}
																	</div>

																	<div
																		class="course-item-footer d-flex justify-content-between">
																		<div class="price">
																			<span class="prise_tag">
																				<span class="current">
																					Rp. {{number_format($realprice - $afterpromo, 0, ',', ' ')}}
																				</span>
																				@if($afterpromo > 0)
																				<del>
																					Rp. {{number_format($realprice, 0, ',', ' ')}}
																				</del>
																				@endif
																			</span>
																		</div>

																		<!-- <a href="#" class="cart_store"
																			data-id="10">
																			<svg width="23" height="20"
																				viewBox="0 0 23 20" fill="none"
																				xmlns="http://www.w3.org/2000/svg">
																				<path
																					d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z"
																					fill="url(#paint0_linear_2677_3208)" />
																				<path
																					d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z"
																					fill="url(#paint1_linear_2677_3208)" />
																				<path
																					d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z"
																					fill="url(#paint2_linear_2677_3208)" />
																				<defs>
																					<linearGradient
																						id="paint0_linear_2677_3208"
																						x1="2.00048"
																						y1="13.4568" x2="20.837"
																						y2="8.70962"
																						gradientUnits="userSpaceOnUse">
																						<stop
																							stop-color="var(--system_primery_gredient1, #660AFB)" />
																						<stop offset="1"
																							stop-color="var(--system_primery_gredient2, #BF37FF)" />
																					</linearGradient>
																					<linearGradient
																						id="paint1_linear_2677_3208"
																						x1="2.00048"
																						y1="13.4568" x2="20.837"
																						y2="8.70962"
																						gradientUnits="userSpaceOnUse">
																						<stop
																							stop-color="#660AFB" />
																						<stop offset="1"
																							stop-color="var(--system_primery_gredient2, #BF37FF)" />
																					</linearGradient>
																					<linearGradient
																						id="paint2_linear_2677_3208"
																						x1="2.00048"
																						y1="13.4568" x2="20.837"
																						y2="8.70962"
																						gradientUnits="userSpaceOnUse">
																						<stop
																							stop-color="#660AFB" />
																						<stop offset="1"
																							stop-color="var(--system_primery_gredient2, #BF37FF)" />
																					</linearGradient>
																				</defs>
																			</svg>

																		</a> -->
																	</div>
																</div>
															</div>
															<div id="class-loading" class="text-center mt_20" hidden>Memuat kelas...</div>
															<div id="class-end" class="text-center mt_20" hidden>Semua kelas sudah ditampilkan.</div>
															<div id="class-error" class="text-center mt_20 text-danger" hidden>Gagal memuat kelas. Silakan coba lagi.</div>
															<div id="class-scroll-sentinel" data-next-page-url="{{ $class->nextPageUrl() }}"></div>
														</div>
														@endforeach
														@php $class = $renderedClassItems ?? $class; @endphp
														<div id="class-loading" class="col-12 text-center mt_20" hidden>Memuat kelas...</div>
														<div id="class-end" class="col-12 text-center mt_20" hidden>Semua kelas sudah ditampilkan.</div>
														<div id="class-error" class="col-12 text-center mt_20 text-danger" hidden>Gagal memuat kelas. Silakan coba lagi.</div>
														<div id="class-scroll-sentinel" class="col-12" data-next-page-url="{{ $class->nextPageUrl() }}"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var filterForm = document.getElementById('class-filter-form');
		var classList = document.getElementById('class-list');
		var sentinel = document.getElementById('class-scroll-sentinel');
		var loading = document.getElementById('class-loading');
		var end = document.getElementById('class-end');
		var error = document.getElementById('class-error');
		var isLoading = false;

		if (!filterForm) {
			return;
		}

		document.querySelectorAll('.class-filter-checkbox').forEach(function(checkbox) {
			checkbox.addEventListener('change', function() {
				filterForm.submit();
			});
		});

		if (!classList || !sentinel || !window.IntersectionObserver) {
			return;
		}

		var observer = new IntersectionObserver(function(entries) {
			if (!entries[0].isIntersecting || isLoading) {
				return;
			}

			loadNextPage(observer);
		}, {
			rootMargin: '300px 0px',
		});

		if (sentinel.dataset.nextPageUrl) {
			observer.observe(sentinel);
		}

		function loadNextPage(observer) {
			var nextPageUrl = sentinel.dataset.nextPageUrl;

			if (!nextPageUrl) {
				observer.disconnect();
				return;
			}

			isLoading = true;
			loading.hidden = false;
			error.hidden = true;

			fetch(nextPageUrl, {
					headers: {
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
					},
					credentials: 'same-origin',
				})
				.then(function(response) {
					if (!response.ok) {
						throw new Error('Failed to load next page');
					}

					return response.json();
				})
				.then(function(response) {
					loading.insertAdjacentHTML('beforebegin', response.html);
					sentinel.dataset.nextPageUrl = response.next_page_url || '';

					if (!response.has_more_pages) {
						observer.disconnect();
						end.hidden = false;
					}
				})
				.catch(function() {
					error.hidden = false;
				})
				.finally(function() {
					isLoading = false;
					loading.hidden = true;
				});
		}
	});
</script>
@endsection