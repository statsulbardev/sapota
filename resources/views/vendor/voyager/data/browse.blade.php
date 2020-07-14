@extends('voyager::master')

@section('page_title', 'Tabel Data')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">Tabel Data</h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="custom-content">
    @include('voyager::alerts')
    <form role="form" class="form-add" action="#" method="POST">
        {{ csrf_field() }}

        <hr style="border:1px solid #E4E4E4">

        <div class="row">
            <div class="right-padding col-md-4">
                <p class="control-label">Tabel & Periode Data</p>
                <div style="text-align:justify">
                    <span class="plain-label">Pilih tabel yang ingin diisikan data serta tahun datanya.</span>
                </div>
            </div>
            <div class="size-padding col-md-8">
                <div class="custom-panel-body panel-body">
                    <label for="templates" class="control-label">Daftar Tabel</label>
                    <select name="template" id="template" class="form-control">
                        <option value="0">Pilih Salah Satu Judul Tabel</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                        @endforeach
                    </select>

                    <br><br>

                    <label for="yearpicker" class="control-label">Tahun Data</label>
                    <input type="text" name="yearpicker" id="yearpicker" class="form-control yearpicker">
                </div>
            </div>
        </div>

        <hr style="border:1px solid #E4E4E4">

        <div class="row">
            <div class="right-padding col-md-4">
                <p class="control-label">Tabel yang Telah Terisi Data</p>
                <div style="text-align:justify">
                    <span class="plain-label">Berikut adalah daftar tabel yang telah
                        diisikan data beserta status pemeriksaannya.
                    </span>
                </div>
            </div>
            <div class="size-padding col-md-8">
                <div class="custom-panel-body panel-body">
                    <label for="konten" class="control-label">Daftar Tabel</label>
                    <div id="content">
                        @if (count($verifications) > 0)
                            @include('_include._data', ['pemeriksaan' => $verifications])
                        @else
                            @include('_include._notfound')
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <hr style="border:1px solid #E4E4E4">

        <div class="row">
            <div class="col-md-12">
                <a href="javascript:;" class="simpan btn btn-info btn-add-new">
                    Tambah Data
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Single delete modal --}}
<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="voyager-trash"></i> Apakah anda ingin menghapus data ini ?</h4>
            </div>
            <div class="modal-footer">
                <form action="#" id="delete_form" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                </form>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('javascript')
    <script src="{{ asset('js/backend/year-select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.btn-add-new').hide();

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#yearpicker').yearselect({
                start: 2010
            });

            $('#template').change(function() {
                if($(this).val() !== '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('voyager.data.show', ['id' => '__id']) }}'.replace('__id', value),
                        data: { template: value, _token: _token },
                        success: function(success) {
                            $('#content').html(success.output);
                            if(success.contentzone) {
                                $('.btn-add-new').show()
                                .attr('href', '{{ route('voyager.data.create', ['id' => '__id', 'year' => '__year']) }}'.replace('__id', template).replace('__year', value));
                            } else {
                                $('.btn-add-new').hide();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });

            $('#yearpicker').change(function() {
                if($(this).val() !== '') {
                    var value = $(this).val();
                    var template = $('#template').val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('voyager.data.show', ['id' => '__id', 'year' => '__year']) }}'.replace('__id', template).replace('__year', value),
                        data: { template: value, _token: _token },
                        success: function(success) {
                            $('#content').html(success.output);
                            if(success.contentzone) {
                                $('.btn-add-new').show()
                                .attr('href', '{{ route('voyager.data.create', ['id' => '__id', 'year' => '__year']) }}'.replace('__id', template).replace('__year', value));
                            } else {
                                $('.btn-add-new').hide();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.data.destroy', ['id' => '__id', 'year' => '__year']) }}'.replace('__id', $(this).data('id')).replace('__year', $(this).data('year'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop