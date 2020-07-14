@extends('voyager::master')

@section('page_title', 'Lihat Tabel Data')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/backend/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/yearpicker.css') }}">
@stop

@section('page_header')
    <h1 class="page-title">Pemeriksaan Data</h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="custom-content">
        @include('voyager::alerts')

        <div class="row">
            <div class="col-md-12">
                @php
                    if ($verification->status === 1) {
                        $border = 'border-info';
                        $text   = 'text-info';
                    } else {
                        $border = 'border-warning';
                        $text   = 'text-warning';
                    }
                @endphp
                <div class="custom-card card  {{ $border }}">
                    <div class="card-header bg-transparent {{ $border }}">
                        <span style="font-weight:bold;font-size:12pt" class="{{ $text }}">
                            Tahun Data {{ $year }}
                        </span>
                        <span class="right-custom-item">
                            {!!
                                ($verification->status === 1) ?
                                '<span class="custom-label label label-info">Final</span>' :
                                '<span class="custom-label label label-warning">Belum Final</span>'
                            !!}
                        </span>
                    </div>
                    <div class="card-body">
                        <span class="card-title indikator-title">{{ $template->name }}</span>
                        <p style="margin-top:6px">
                            {!! ($verification->check === 1) ?
                                '<span class="text-periksa text-info">Sudah Diperiksa</span>' :
                                '<span class="text-periksa text-warning">Belum Diperiksa</span>'
                            !!}
                        </p>
                        <br>
                        <p class="control-label">Catatan Pemeriksaan</p>
                        @if (count($verification->supervisor) > 0)
                            @php
                                $catatan = $verification->note;
                                $supervisor = $verification->supervisor;
                                $tanggal_cek = $verification->date_check;
                            @endphp
                            @foreach ($verification->supervisor as $index => $item)
                                <ul>
                                    <li>
                                        <p class="plain-text">
                                            {{ $catatan[$index] }}
                                        </p>
                                        <p><b>
                                            Supervisor :
                                            {{ TCG\Voyager\Models\User::select('name')
                                               ->where('id', $supervisor[$index])->get()[0]['name']
                                            }},
                                            Tanggal periksa :
                                            {{ date('d / m / Y', strtotime($tanggal_cek[$index]['date'])) }}
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
                        <span style="font-weight:bold">
                            Dibuat : {{ date('d / m / Y', strtotime($template->created_at)) }}
                        </span>
                        <span style="font-weight:bold" class="right-custom-item">
                            Diperbaharui : {{ date('d / m / Y', strtotime($template->updated_at)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-border">
                    {{-- Tahun n --}}
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Tabel Tahun {{ $year}}</h3>
                    </div>
                    <div class="panel-body" style="padding-top:0;">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle !important; width:2%" rowspan="2">
                                            No.
                                        </th>
                                        <th class="text-center" style="vertical-align: middle !important" rowspan="2">
                                            {{ $row->name }}
                                        </th>
                                        <!-- Untuk jumlah variabel > 1 -->
                                        @foreach ($column as $index => $judulKolom)
                                        <th class="text-center" colspan="{{ count($columnDetail[$index]) }}">
                                            {{ $judulKolom->name }}
                                        </th>
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
                                                <td class="text-center">
                                                    <span name="{{ $anakBaris->id }}_{{ $anakKolom->id }}">
                                                        {{ $data[$count]->value }}
                                                    </span>
                                                </td>
                                                @php
                                                    $count++;
                                                @endphp
                                                @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- Tahun n-1 --}}
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Tabel Tahun {{ $year - 1 }}</h3>
                    </div>
                    @if (count($old_data) !== 0)
                        <div class="panel-body" style="padding-top:0;">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" class="table table-bordered hover" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="vertical-align: middle !important; width:2%" rowspan="2">
                                                No.
                                            </th>
                                            <th class="text-center" style="vertical-align: middle !important" rowspan="2">
                                                {{ $row->name }}
                                            </th>
                                            <!-- Untuk jumlah variabel > 1 -->
                                            @foreach ($column as $index => $judulKolom)
                                            <th class="text-center" colspan="{{ count($columDetail[$index]) }}">
                                                {{ $judulKolom->name }}
                                            </th>
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
                                                    <td class="text-center">
                                                        <span name="{{ $anakBaris->id }}_{{ $anakKolom->id }}">
                                                            {{ $old_data[$count]->value }}
                                                        </span>
                                                    </td>
                                                    @php
                                                        $count++;
                                                    @endphp
                                                    @endforeach
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div style="padding-left:15px;padding-right:15px;padding-bottom:15px">
                            @include('_include._notfound')
                        </div>
                    @endif

                    <div class="panel-body">
                        <a href="javascript:;" title="Delete" class="simpan btn btn-sm btn-info pull-left check">
                            Penilaian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-info fade" tabindex="-1" id="check_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-activity"></i> Berikan Penilaian</h4>
                </div>
                <form style="margin-top:3%" action="#" id="check_form" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group col-md-12 col-sm-12">
                        <label for="catatan" class="control-label">Catatan Tambahan</label>
                        <textarea class="form-control" name="catatan" id="catatan" rows="5"></textarea>
                    </div>
                    <div class="form-group col-md-12 col-sm-12">
                        <label for="check-point" class="control-label">Hasil Pemeriksaan</label><br>
                        <label class="radio-inline"><input type="radio" name="status" value="1" checked>Layak Tampil</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">Belum Layak Tampil</label>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info pull-right check-confirm" value="Simpan">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('.check').click(function (e) {
            $('#check_form')[0].action = '{{ route('voyager.verifications.check', ['id' => '__id', 'year' => '__year']) }}'.replace('__id', {{ $verification->id }}).replace('__year', {{ $year }});
            $('#check_modal').modal('show');
        });
    </script>
@stop