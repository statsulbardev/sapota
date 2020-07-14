@extends('frontend.layout.app')

@section('title', 'Data Sektoral')

@section('style')
<link rel="stylesheet" href="{{ asset('css/frontend/custom/style.css') }}">
@endsection

@section('content')
<section>
	<div class="container">
		<div class="row mt-4">
			<div class="col-lg-8">
				<div id="accordion" class="faq accordion accordion-custom pb-5">
					<div class="card dataset-header">
						<div id="headingOne">
							<span>Menampilkan {{ count($listOfData) }} Data</span>
						</div>
					</div>
					<div class="list-group">
						@foreach($listOfData as $data)
							<div class="list-data">
								<a href="{{ route('show_data_detail', [
										'id'   => $data->template_id,
										'year' => $data->year
									]) }}" class="data-title">
									{{ ucwords(strtolower(\App\Models\Template::findOrFail($data->template_id)->name)) }}
									Tahun {{ $data->year }}
								</a><br>
								<small>
									{{ \TCG\Voyager\Models\User::findOrFail(\App\Models\Template::findOrFail($data->template_id)->assign)->name }},
									Tanggal Rilis : {{ date("d / m / Y", strtotime($data->created_at)) }}
								</small><br>
								<small o="/dataset/bps_api_160160" data-format="api">
									<span class="badge badge-success">Excel</span>
								</small>
							</div>
						@endforeach
					</div>
					{{ $listOfData->links("pagination::bootstrap-4") }}
				</div>
			</div>

        	<!-- sidebar-->
			<aside class="sidebar col-lg-4 mt-5 mt-lg-0">
				<div class="search mb-4">
					<form action="#" class="search-form">
						<div class="form-group">
							<input type="search" name="search" placeholder="Cari" class="form-control">
							<button type="submit"> <i class="fa fa-search"></i></button>
						</div>
					</form>
				</div>
				<div style="margin-bottom:5rem">
					<div class="accordion" id="accordionExample">
						<div class="card" style="border:none">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
									<button class="btn" type="button" data-toggle="collapse"
										data-target="#collapseOne" aria-expanded="true"
										aria-controls="collapseOne" style="padding-left:0px;text-transform:none">
										Instansi Pemerintah
									</button>
								</h2>
							</div>
							<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body" style="background-color:#e6e6e6">
									<ul class="list-instansi pl-0 mt-2">
										@if($sumOfData->count() > 0)
											@foreach($sumOfData as $template)
												<li class="sidebar-widget-custom mb-2">
													<a style="color:black;width:13rem" href="{{ route('show_data_by_institution', $template->assign) }}">
														{{ \TCG\Voyager\Models\User::findOrFail($template->assign)->name }}
													</a>
													<span style="margin-top:0.3rem" class="badge badge-primary badge-pill item-right">
														{{ $template->sum }}
													</span>
												</li>
											@endforeach
										@else
											<li class="sidebar-widget-custom mb-2">
												<span>Data Belum Tersedia</span>
											</li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</div>
	</div>
</section>
@endsection