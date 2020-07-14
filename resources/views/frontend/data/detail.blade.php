@extends('frontend.layout.app')

@section('title', 'Detail Data')

@section('style')
<link rel="stylesheet" href="{{ asset('css/frontend/custom/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/widget/widget.min.css') }}">
@endsection

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row align-items-center mt-4 mb-4 mr-2">
                    <div class="col-md-12 text-right">
                        <button name="create_excel" id="create_excel" class="btn btn-sm btn-success">
                            <i class="fa fa-download"></i> Unduh Tabel
                        </button>
                        {{-- <button name="create_pdf" id="create_pdf" class="btn btn-sm btn-danger">PDF</button> --}}
                    </div>
                </div>
                <div class="card-argon-widget">
                    <div id="data_table" class="table-responsive">
                        <!-- Projects table -->
                        <table id="my-data" class="dashboard-table align-items-center table table-bordered data-table">
                            <caption style="color:#212529;font-weight:600;caption-side:top;text-align:center">
                                Tabel {{ ucwords(strtolower(\App\Models\Template::findOrFail($data[0]->template_id)->name)) }}
                                Tahun {{ $data[0]->year }}
                            </caption>
                            <thead style="background-color:#117DB9;color:white">
                                <tr>
                                    <th scope="col" class="text-center" style="vertical-align: middle !important; width:2%" rowspan="2">No.</th>
                                    <th scope="col" class="text-center" style="vertical-align: middle !important" rowspan="2">{{ $row->name }}</th>
                                    <!-- Untuk jumlah variabel > 1 -->
                                    @foreach ($column as $index => $columnTitle)
                                        <th class="text-center" colspan="{{ count($columnDetail[$index]) }}">{{ $columnTitle->name }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($columnDetail as $index => $columnChild)
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
                                @foreach($rowDetail as $index => $rowChild)
                                    <tr class="baris">
                                        <td class="table-content text-center">{{ $index + 1 }}</td>
                                        <td class="table-content {{ $row->name }}">{{ $rowChild->name }}</td>
                                        @foreach($columnDetail as $index => $item)
                                            @foreach ($columnDetail[$index] as $dex => $columnChild)
                                                <td class="table-content text-center">
                                                    <span name="{{ $rowChild->id }}_{{ $columnChild->id }}">
                                                        {{ number_format($data[$count]->value, 0, ",", ".") }}
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
                            <tfoot style="border:none">
                                @php
                                    $colspan = 2;
                                    foreach ($columnDetail as $index => $value) {
                                        foreach ($columnDetail[$index] as $key => $value) {
                                            $colspan += 1;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td colspan="{{ $colspan }}">Sumber : {{ $templateData[0]->source }}</td>
                                </tr>
                                <tr>
                                    <td colspan="{{ $colspan }}">Catatan : {{ ($templateData[0]->description === null) ? 'Tidak ada catatan' : $templateData[0]->description }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
    <script src="{{ asset('js/backend/FileSaver.min.js') }}"></script>
    <script src="{{ asset('js/backend/jquery.tableToExcel.js') }}"></script>
    {{-- <script src="{{ asset('js/j/jspdf.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/j/jspdf.plugin.autotable.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/j/tableExport.js') }}"></script> --}}
    <script>
        $('#create_excel').click(function() {
            $('#my-data').tblToExcel();
        });
        // $('#create_pdf').click(function() {
        //     // $('#my-data').tableExport({type:'pdf',escape: 'false'});
        //     var doc = new jsPDF();
        //     doc.autoTable
        // });
    </script>
@endpush