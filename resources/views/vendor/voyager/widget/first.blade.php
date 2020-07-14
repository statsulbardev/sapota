@section('css')
<link rel="stylesheet" href="{{ asset('css/icons/font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/icons/ionicons.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/widget/widget.min.css') }}">
@endsection

<div class="row row-up">
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a class="card-first-widget bg-red bg-inverse" href="javascript:void(0)">
            <div class="card-block clearfix">
                <div class="pull-right">
                    <p class="h6 text-muted m-t-0 m-b-xs">Jumah User</p>
                    <p class="h3 m-t-sm m-b-0">{{ $user }} User</p>
                </div>
                <div class="pull-left m-r">
                    <span class="img-avatar img-avatar-48 bg-blue bg-gray-light-o"><i class="ion-ios-people fa-1-5x"></i></span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a class="card-first-widget bg-green bg-inverse" href="javascript:void(0)">
            <div class="card-block clearfix">
                <div class="pull-right">
                    <p class="h6 text-muted m-t-0 m-b-xs">Jumlah Indikator</p>
                    <p class="h3 m-t-sm m-b-0">{{ $template }}</p>
                </div>
                <div class="pull-left m-r">
                    <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-speedometer fa-1-5x"></i></span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a class="card-first-widget bg-blue bg-inverse" href="javascript:void(0)">
            <div class="card-block clearfix">
                <div class="pull-right">
                    <p class="h6 text-muted m-t-0 m-b-xs">Jumlah Tabel</p>
                    <p class="h3 m-t-sm m-b-0">{{ $tabel }}</p>
                </div>
                <div class="pull-left m-r">
                    <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-list fa-1-5x"></i></span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
        <a class="card-first-widget bg-purple bg-inverse" href="javascript:void(0)">
            <div class="card-block clearfix">
                <div class="pull-right">
                    <p class="h6 text-muted m-t-0 m-b-xs">Jumlah Infografis</p>
                    <p class="h3 m-t-sm m-b-0">0</p>
                </div>
                <div class="pull-left m-r">
                    <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-paper fa-1-5x"></i></span>
                </div>
            </div>
        </a>
    </div>
</div>