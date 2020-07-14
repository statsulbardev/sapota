<table id="dataTable" class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th class="text-center">Nama Indikator</th>
            <th class="text-center">Tahun Data</th>
            <th class="text-center">Status Pemeriksaan</th>
            <th class="text-center">Catatan</th>
            <th class="text-center">Status Data</th>
            <th class="actions text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pemeriksaan as $index => $periksa)
        <tr>
            {{-- No. --}}
            <td>{{ $index + 1 }}</td>
            {{-- Nama Indikator --}}
            <td>
                {{
                    App\Models\Indikator::select('nama')
                    ->where('id', $periksa->indikator_id)->get()[0]['nama']
                }}
            </td>
            {{-- Tahun Data --}}
            <td class="text-center"> {{ $periksa->tahun }}</td>
            {{-- Status Pemeriksaan --}}
            <td class="text-center">
                {!!
                    ($periksa->cek === true) ? '<span class="label label-info">Sudah Diperiksa</span>' :
                    '<span class="label label-warning">Belum Diperiksa</span>'
                !!}
            </td>
            {{-- Catatan --}}
            <td>
                @if (count($periksa->supervisor) > 0)
                    <p>
                        @php
                            $catatan = $periksa->catatan;
                            $supervisor = $periksa->supervisor;
                            $tanggal_cek = $periksa->tanggal_cek;
                            $count = count($periksa->supervisor);
                        @endphp
                        {{ $catatan[$count-1] }}
                    </p>
                    <small><b>
                        Supervisor : {{ TCG\Voyager\Models\User::select('name')->where('id', $supervisor[$count-1])->get()[0]['name'] }},
                        Tanggal periksa : {{ date('d-m-Y', strtotime($tanggal_cek[$count-1]['date'])) }}
                    </b></small>
                @else
                    <p>Belum Ada Catatan Pemeriksaan.</p>
                    <small><b>Supervisor : -, Tanggal Pemeriksaan : -</b></small>
                @endif
            </td>
            {{-- Status Data --}}
            <td class="text-center">
                {!!
                    ($periksa->status === true) ? '<span class="label label-info">Final</span>' :
                    '<span class="label label-warning">Belum Final</span>'
                !!}
            </td>
            {{-- Tombol Aksi --}}
            <td class="text-center">
                <a href="{{ route('voyager.pemeriksaan.view', ['id' => $periksa->id, 'tahun' => $periksa->tahun]) }}"
                    title="Periksa" class="btn btn-sm btn-primary periksa">
                    <i class="voyager-window-list"></i> Periksa Data
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>