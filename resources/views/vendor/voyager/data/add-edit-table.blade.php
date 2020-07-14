@extends('voyager::master')

@section('page_title', ($tahapan === 'tambah') ?
    'Tambah Data '. $template->name :
    'Perbaharui Data '. $template->name
)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-list"></i> {{ $template->name }} Tahun {{ $year }}
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                <form role="form" class="form-add"
                action="{{ ($tahapan === 'tambah') ?
                    route('voyager.data.save', ['id' => $template->id, 'year' => $year]) :
                    route('voyager.data.update', ['id' => $template->id, 'year' => $year]) }}"
                method="POST">
                    {{ csrf_field() }}

                    {{-- jika form ini merupakan edit form --}}
                    @if ($tahapan === 'edit')
                        {{ method_field('PATCH') }}
                    @endif

                    <div class="panel-body">
                        <span class="panel-desc">
                            <b>Isikan data pada <em>cell</em> tabel dengan benar dan teliti.
                                Anda dapat melakukan <em>copy & paste</em> data dari file spreadsheet (.xls, .xlsx).
                            </b>
                        </span>
                    </div>
                    <div class="panel-body">
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
                                    @if ($tahapan === 'edit')
                                        <tr class="baris">
                                            <td class="text-center nomor">{{ $index + 1 }}</td>
                                            <td class="{{ $row->name }}">{{ $anakBaris->name }}</td>
                                            @foreach($columnDetail as $index => $item)
                                                @foreach ($columnDetail[$index] as $dex => $anakKolom)
                                                    {{-- cek ulang di method editnya --}}
                                                    <td class="text-center">
                                                        <input id="form-input" name="{{ $row->id }}_{{ $anakBaris->id }}_{{ $column[$index]->id }}_{{ $anakKolom->id}}" type="text"
                                                        value="{{ $data[$count]->value }}" required>
                                                    </td>
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    @else
                                        <tr class="baris">
                                            <td class="text-center nomor">{{ $index + 1 }}</td>
                                            <td class="{{ $row->name }}">{{ $anakBaris->name }}</td>
                                            @foreach($columnDetail as $index => $item)
                                                @foreach ($columnDetail[$index] as $dex => $anakKolom)
                                                <td class="text-center">
                                                    <input id="form-input" name="{{ $row->id }}_{{ $anakBaris->id }}_{{ $column[$index]->id }}_{{ $anakKolom->id }}"
                                                    type="text" required>
                                                </td>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-lg-1 col-sm-1 text-right">
                                <span>Sumber Data :</span>
                            </div>
                            <div class="col-md-11 col-lg-11 col-sm-11">
                                <input style="width:100%" type="text" name="source" placeholder="Contoh. Sumber dari laporan registrasi, atau hasil pengolahan survey" value="{{ ($templateData[0]->source) ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-lg-1 col-sm-1 text-right">
                                <span>Catatan :</span>
                            </div>
                            <div class="col-md-11 col-lg-11 col-sm-11">
                                <textarea style="width:100%" name="description">{{ ($templateData[0]->description) ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                      <button id="save" type="submit" class="btn btn-primary save"><i class="voyager-down-circled"></i> Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
    $(document).ready(function() {
        // tabel input paste
        $('td input').bind('paste', null, function (e) {
            $txt = $(this);
            setTimeout(function () {
                var values = $txt.val().split(/\s+/);

                var currentRowIndex = $txt.parent().parent().index(); // index ke 0 baris
                var currentColIndex = 2;

                var totalRows = $('#example tbody tr').length; // panjang baris
                var totalCols = $('#example thead #kolom').length; // panjang kolom

                var count = 0;
                for(var baris = currentRowIndex; baris < totalRows; baris++) {
                    if(baris != currentRowIndex) currentColIndex = 2;
                    for(var kolom = currentColIndex; kolom < totalCols + 2; kolom++) {
                        var value = values[count];
                        var inp = $('#example tbody tr').eq(baris).find('td').eq(kolom).find('input');
                        inp.val(value);
                        count++;
                    }
                }
            }, 0);
        });
    });
  </script>
@stop