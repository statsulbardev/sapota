@extends('voyager::master')

@section('page_title', 'Lihat Data')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/backend/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/yearpicker.css') }}">
@stop

@section('page_header')
    <h1 class="page-title">Lihat Data</h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="custom-content">
        @include('voyager::alerts')

        <div class="row">
            <div class="col-md-12">
                @php
                    if ($verification->status === true) {
                        $border = 'border-info';
                        $text   = 'text-info';
                    } else {
                        $border = 'border-warning';
                        $text   = 'text-warning';
                    }
                @endphp
                <div class="custom-card card {{ $border }}">
                    <div class="card-header bg-transparent {{ $border }}">
                        <span style="font-weight:bold;font-size:12pt" class="{{ $text }}">Tahun Data {{ $verification->year }}</span>
                        <span class="right-custom-item">
                                {!!
                                    ($verification->status === true) ? '<span class="custom-label label label-info">Final</span>' :
                                    '<span class="custom-label label label-warning">Belum Final</span>'
                                !!}
                        </span>
                    </div>
                    <div class="card-body">
                        <span class="card-title indikator-title">{{ $template->name }}</span>
                        <p style="margin-top:6px">
                            {!! ($verification->check === true) ?
                                '<span class="label label-info">Sudah Diperiksa</span>' :
                                '<span class="label label-warning">Belum Diperiksa</span>'
                            !!}
                        </p>
                        <br>
                        <p class="control-label">Catatan Pemeriksaan</p>
                        @if (count($verification->supervisor) > 0)
                            @php
                                $note       = $verification->note;
                                $supervisor = $verification->supervisor;
                                $date_check = $verification->date_check;
                            @endphp
                            @foreach ($verification->supervisor as $index => $item)
                                <ul>
                                    <li>
                                        <h5>
                                            {{ $note[$index] }}
                                        </h5>
                                        <p><b>
                                            Supervisor : {{ TCG\Voyager\Models\User::select('name')->where('id', $supervisor[$index])->get()[0]['name'] }},
                                            Tanggal periksa : {{ date('d / m / Y', strtotime($date_check[$index]['date'])) }}
                                        </b></p>
                                    </li>
                                </ul>
                            @endforeach
                        @else
                            <p>Belum Ada Catatan Pemeriksaan.</p>
                            <small><b>Supervisor : -, Tanggal Pemeriksaan : -</b></small>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent {{ $border }} {{ $text }}">
                            <span style="font-weight:bold">Dibuat : {{ date('d / m / Y', strtotime($template->created_at)) }}</span>
                            <span style="font-weight:bold" class="right-custom-item">Diperbaharui : {{ date('d / m / Y', strtotime($template->updated_at)) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
           <div class="col-md-12">
                <div class="panel panel-border">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Tabel Data</h3>
                    </div>
                    <div class="panel-body" style="padding-top:0;">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle !important; width:2%" rowspan="2">No.</th>
                                        <th class="text-center" style="vertical-align: middle !important" rowspan="2">{{ $row->name }}</th>
                                        <!-- Untuk jumlah variabel > 1 -->
                                        @foreach ($column as $index => $judulKolom)
                                        <th class="text-center" colspan="{{ count($columnDetail[$index]) }}">{{ $judulKolom->name }}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach($columnDetail as $index => $anakKolom)
                                            @foreach ($columnDetail[$index] as $dex => $item)
                                                <th id="kolom" class="text-center">{{ $item->name }}</th>
                                            @endforeach
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach($rowDetail as $index => $anakBaris)
                                    <tr class="baris">
                                        <td class="text-center nomor">{{ $index + 1 }}</td>
                                        <td class="{{ $row->name }}">{{ $anakBaris->name }}</td>
                                        @foreach($columnDetail as $index => $item)
                                            @foreach ($columnDetail[$index] as $dex => $anakKolom)
                                                <td class="text-center"><span name="{{ $row->id }}_{{ $anakBaris->id }}_{{ $column[$index]->id }}_{{ $anakKolom->id }}">{{ $data[$count]->value }}</span></td>
                                                @php
                                                    $count++;
                                                @endphp
                                                @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg2 text-right">
                                    <span>Sumber Data :</span>
                                </div>
                                <div class="col-sm-10 col-md-10 col-lg-10">
                                    <span>{{ $templateData[0]->source }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2 text-right">
                                    <span>Catatan : </span>
                                </div>
                                <div class="col-sm-10 col-md-10 col-lg-10">
                                    <span>{{ ($templateData[0]->description) ?? 'Tidak ada catatan' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop