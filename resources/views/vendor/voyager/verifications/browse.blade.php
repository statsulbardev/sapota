@extends('voyager::master')

@section('page_title', 'Pemeriksaan Data')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pemeriksaan.min.css') }}">
@stop

@section('page_header')
    <h1 class="page-title">Pemeriksaan Tabel Data</h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="custom-content">
    @include('voyager::alerts')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9" style="margin: 9px 0px!important">
                            <span id="total-table" class="badge badge-secondary">
                                {{ count($tableInfo) }}
                            </span>
                            <a href="{{ route('voyager.verifications.index') }}" class="total-table badge-link space-margin-left">
                                Jumlah Tabel
                            </a>
                            <span id="final-table" class="badge badge-success space-more-margin-left">
                                {{ count($tableInfo->where('status', 1)) }}
                            </span>
                            <a href="#" class="final-table badge-link space-margin-left">
                                Data Final
                            </a>
                            <span id="not-final-table" class="badge badge-warning space-more-margin-left">
                                {{ count($tableInfo->where('check', 1)->where('status', 0)) }}
                            </span>
                            <a href="#" class="not-final-table badge-link space-margin-left">
                                Data Belum Final
                            </a>
                            <span id="not-check-table" class="badge badge-danger space-more-margin-left">
                                {{ count($tableInfo->where('check', 0)) }}
                            </span>
                            <a href="#" class="not-check-table badge-link space-margin-left">
                                Data Belum Diperiksa
                            </a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px !important">
                            <div class="box">
                                <div class="container-1">
                                    <span class="icon"><i class="voyager-search"></i></span>
                                    <input type="search" id="cari" placeholder="Cari...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid">
        @foreach($datas as $data)
        <div class="item
            @if ($data->check == 0 && $data->status == 0) uncheck
            @elseif($data->check == 1 && $data->status == 0) check-warning
            @else check
            @endif
        ">
            <div class="content">
                <div class="title card-header-title">
                    <img src="
                        @if ($data->check == 0 && $data->status == 0) {{ asset('images/icon/uncheck.svg') }}
                        @elseif($data->check == 1 && $data->status == 0) {{ asset('images/icon/unverified.svg') }}
                        @else {{ asset('images/icon/verified.svg') }}
                        @endif
                    " class="inner card-img-top" style="width:50px">
                    <h4 class="inner">{{ $data->name }}</h4>
                </div>
                <div class="desc">
                    <h4 class="card-text">{{ $data->name }} Tahun {{ $data->year }}</h4>
                </div>
                <div class="periksa">
                    <a href="{{ route('voyager.verifications.view', ['id' => $data->id, 'year' => $data->year]) }}">
                        <i class="voyager-pen"></i> Periksa Tabel
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop

@section('javascript')
    <script src="{{ asset('js/backend/masonry.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.final-table').click(function() {
                $.get('{{ route('voyager.verifications.getByStatus', ['check' => '__check', 'status' => '__status']) }}'.replace('__check', 1).replace('__status', 1), function(data, status) {
                    //
                });
            });

            $('.not-final-table').click(function() {
                $.get('{{ route('voyager.verifications.getByStatus', ['check' => '__check', 'status' => '__status']) }}'.replace('__check', 1).replace('__status', 0), function(data, status) {
                    //
                });
            });

            $('.not-check-table').click(function() {
                $.get('{{ route('voyager.verifications.getByStatus', ['check' => '__check', 'status' => '__status']) }}'.replace('__check', 0).replace('__status', 0), function(data, status) {
                    //
                });
            });
        });
    </script>
@stop