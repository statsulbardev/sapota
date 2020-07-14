@extends('frontend.layout.app')

@section('title', 'Bank Data Sulawesi Barat')

@section('content')
<section class="hero">
	<div class="container mb-5">
		<div class="row align-items-center">
		<div class="col-lg-6">
			<h1 class="hero-heading mb-0 custom-h1">Data Sulawesi Barat <br> Dalam Satu Portal</h1>
			<div class="row">
			<div class="col-lg-10">
				<p class="lead text-muted mt-4 mb-4">Data yang dihimpun merupakan data-data sektoral dari OPD di Provinsi Sulawesi Barat.</p>
			</div>
			</div>
			<form action="#" class="subscription-form">
			{{-- <div class="form-group">
				<input type="email" name="email" placeholder="Masukkan Kata Kunci" class="form-control">
				<button type="submit" class="btn btn-primary">Cari</button>
			</div> --}}
			</form>
		</div>
		<div class="col-lg-6">
			<img src="{{ asset('images/appton/illustration-hero.svg') }}" alt="..."
				class="hero-image img-fluid d-none d-lg-block">
		</div>
		</div>
	</div>
</section>
<section>
    <div class="container">
        <div class="text-center">
            <h2>Data Sektoral Sulawesi Barat</h2>
			<p class="lead text-muted mt-2">Dapatkan data sektoral dengan mudah. Data yang dihimpun berasal dari berbagai sektor<br>
				dan instansi pemerintah di Provinsi Sulawesi Barat.</p>
			<a href="{{ route('show_data_page') }}" class="btn btn-primary">Dapatkan Data</a>
        </div>
        <div class="row">
            <div class="col-lg-7 mx-auto mt-5">
				<img src="{{ asset('images/appton/illustration-3.svg') }}" alt="..."
					class="intro-image img-fluid">
				</div>
        </div>
    </div>
</section>
<section class="bg-primary text-white">
	<div class="container">
		<div class="text-center">
		<h2>Ragam Data</h2>
		<div class="row">
			<div class="col-lg-9 mx-auto">
				<p class="lead text-white mt-2">
					Jenis data yang tersedia beragam menurut sektor maupun instansi pemerintah.
				</p>
			</div>
		</div>
		<div class="integrations mt-5">
			<div class="row">
				<div class="col-lg-4">
					<div class="box text-center">
						<div class="icon d-flex align-items-end">
							<img src="{{ asset('images/appton/1-economic.svg') }}" alt="..." class="img-fluid">
						</div>
						<h3 class="h4">Ekonomi, Pariwisata, dan Perdagangan</h3>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box text-center">
						<div class="icon d-flex align-items-end">
							<img src="{{ asset('images/appton/2-social.svg') }}" alt="..." class="img-fluid">
						</div>
						<h3 class="h4">Sosial, Kependudukan, dan Ketenagakerjaan</h3>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="box text-center">
						<div class="icon d-flex align-items-end">
							<img src="{{ asset('images/appton/3-agriculture.svg') }}" alt="..." class="img-fluid">
						</div>
						<h3 class="h4">Industri, Pertanian, dan Pertambangan</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection