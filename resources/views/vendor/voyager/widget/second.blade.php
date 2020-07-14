@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/widget/widget.min.css') }}">
@endsection

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card-argon-widget">
            <div class="card-argon-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0 custom-h2">Data terbaru {{ Auth::user()->name }}</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" class="btn btn-sm btn-purple">Lihat Semua</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="dashboard-table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Judul Tabel</th>
                            <th scope="col">Tahun Data</th>
                            <th scope="col">Tanggal Upload</th>
                            <th scope="col">Status Pemeriksaan</th>
                            <th scope="col">Status Data</th>
                            <th scope="col">Lihat Tabel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">{{ $item->name }}</th>
                                <td>{{ $item->year }}</td>
                                <td>{{ date("d / m / Y", strtotime($item->created_at)) }}</td>
                                <td>{!! ($item->check == 0) ? '<span class="custom-label label label-warning">Belum Diperiksa</span>' : '<span class="custom-label label label-info">Sudah Diperiksa</span>' !!}</td>
                                <td>{!! ($item->status == 0) ? '<span class="custom-label label label-warning">Belum Final</span>' : '<span class="custom-label label label-info">Sudah Final</span>' !!}</td>
                                <td>
                                    <a href="#">
                                        <span class="img-avatar img-avatar-48 bg-blue bg-gray-light-o">
                                            <i class="ion-ios-arrow-right fa-1-5x"></i>
                                        </span>
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