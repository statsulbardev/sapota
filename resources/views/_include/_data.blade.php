<style>
    .card-argon-widget{position:relative;display:flex;flex-direction:column;min-width:0;margin-left:20px;margin-right:20px;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:2px solid rgba(0,0,0,.07);border-radius:.375rem}
    .card-argon-widget .dashboard-table{margin-bottom:0}
    .card-argon-widget .dashboard-table td, .card-argon-widget .dashboard-table th{padding-left:1.5rem;padding-right:1.5rem}
    .dashboard-table{width:100%;margin-bottom:1rem;background-color:transparent}
    .dashboard-table td, .dashboard-table th{font-size:.8125rem;padding:1rem;vertical-align:top;border-top:1px solid #e9ecef}
    .dashboard-table th{font-weight:600}
    .dashboard-table .thead-light th{background-color:#f6f9fc;color: #8898aa;border-color:#e9ecef}
    .dashboard-table.align-items-center td, .dashboard-table.align-items-center th{vertical-align:middle}
    .dashboard-table thead th{padding-top:.75rem;padding-bottom:.75rem;font-size:.8125rem;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #e9ecef;vertical-align:bottom}
    .table-flush td, .table-flush th{border-left:0;border-right:0}
    .table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style: -ms-autohiding-scrollbar}
</style>

<div class="row">
    <div class="col" style="margin:0!important;padding:0!important">
        <div class="card-argon-widget" style="margin:0 15px!important">
            <div class="table-responsive">
                <!-- Projects table -->
                <table id="dataTable" style="table-layout:fixed;word-wrap:break-word"
                    class="table table-bordered dashboard-table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr style="height:3rem">
                            <th width="7%" style="font-weight:600">No.</th>
                            <th width="79%" style="font-weight:600" class="text-center">Judul Tabel</th>
                            <th width="14%" style="font-weight:600" class="actions text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemeriksaan as $index => $periksa)
                        <tr>
                            {{-- No. --}}
                            <td><span style="font-size:16px">{{ $index + 1 }}</span></td>
                            {{-- Nama Indikator --}}
                            <td>
                                <p style="font-size:16px">
                                    {{ App\Models\Template::select('name')
                                       ->where('id', $periksa->template_id)->get()[0]['name']
                                    }} Tahun {{ $periksa->year }}
                                </p>
                                <div style="margin-top:1rem;margin-bottom:1.5rem">
                                    <span>
                                        {!!
                                            ($periksa->check === 1) ?
                                                '<span style="font-size:14px" class="label label-info">Sudah Diperiksa</span>' :
                                                '<span style="font-size:14px" class="label label-warning">Belum Diperiksa</span>'
                                        !!}
                                    </span>
                                    <span>
                                        {!!
                                            ($periksa->status === 1) ?
                                                '<span style="font-size:14px" class="label label-info">Final</span>' :
                                                '<span style="font-size:14px" class="label label-warning">Belum Final</span>'
                                        !!}
                                    </span>
                                </div>
                                <span style="font-size:16px!important">
                                    <p style="font-weight:600;margin-bottom:5px">Catatan Pemeriksaan :</p>
                                    @if (count($periksa->supervisor) > 0)
                                        <p>
                                            @php
                                                $catatan = $periksa->note;
                                                $supervisor = $periksa->supervisor;
                                                $tanggal_cek = $periksa->date_check;
                                                $count = count($periksa->supervisor);
                                            @endphp
                                            "{{ $catatan[$count-1] }}"
                                        </p>
                                        <span><b>
                                            Supervisor :
                                                {{ TCG\Voyager\Models\User::select('name')
                                                   ->where('id', $supervisor[$count-1])
                                                   ->get()[0]['name']
                                                }},
                                            Tanggal periksa :
                                                {{ date('d / m / Y', strtotime($tanggal_cek[$count-1]['date'])) }}
                                        </b></span>
                                    @else
                                        <p>"Belum Ada Catatan Pemeriksaan"</p>
                                        <span><b>Supervisor : -, Tanggal Pemeriksaan : -</b></span>
                                    @endif
                                </span>
                            </td>
                            {{-- Tombol Aksi --}}
                            <td class="no-sort no-click" id="bread-actions">
                                <a href="javascript:;" title="Hapus" name="Delete"
                                    class="btn btn-sm btn-danger pull-right delete"
                                    data-id={{ $periksa->id }} data-tahun={{ $periksa->year }}>
                                    <i class="voyager-trash"></i>
                                </a>
                                <a href="{{ route('voyager.data.edit', ['id' => $periksa->id, 'year' => $periksa->year]) }}"
                                    title="Ubah" class="btn btn-sm btn-primary pull-right edit">
                                    <i class="voyager-edit"></i>
                                </a>
                                <a href="{{ route('voyager.data.view', ['id' => $periksa->id, 'year' => $periksa->year]) }}"
                                    title="Lihat" class="btn btn-sm btn-warning pull-right view">
                                    <i class="voyager-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>