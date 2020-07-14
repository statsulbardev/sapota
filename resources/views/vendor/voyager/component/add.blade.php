@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', $value['judulPendek'])

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list-add"></i> {{ $value['judul'] }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-add" action="{{ $value['route'] }}"
                        method="POST" enctype="multipart/form-data">
                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group col-md-12">
                                <label for="nama">{{ $value['labelNama'] }}</label>
                                <input required type="text" class="form-control" name="name"
                                    placeholder="{{ $value['placeNama'] }}" value>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="item">{{ $value['labelItem'] }}</label>
                                <table class="table table-bordered" id="dynamic_field">
                                    <tr>
                                        <td class="col-md-10">
                                            <input type="text" name="item[]" id="item" class="form-control name_list"
                                                placeholder="{{ $value['placeItem'] }}">
                                        </td>
                                        <td class="col-md-2 text-center" style="vertical-align:middle">
                                            <input type="button" name="add" id="add"
                                                class="btn btn-success btn_add" value="(+) Tambah Indikator">
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer text-right">
                            <button type="submit" class="simpan btn btn-primary save"
                                style="margin-right:1rem;float:none!important">
                                {{ __('voyager::generic.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal Form --}}
    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        <i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{ __('voyager::generic.cancel') }}
                    </button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">
                        {{ __('voyager::generic.delete_confirm') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
<script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row'+ i +'"><td><input type="text" name="item[]" id="item" class="form-control name_list" placeholder="{{ $value['placeItem'] }}"></td><td class="text-center" style="vertical-align:middle"><input type="button" name="remove" id="'+ i +'" class="btn btn-danger btn_remove" value="(x) Hapus Indikator"></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row'+ button_id +'').remove();
        });
    });
</script>
@stop