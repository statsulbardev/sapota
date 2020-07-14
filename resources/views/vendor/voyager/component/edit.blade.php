@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', $value['judulPendek'])

@section('page_header')
    <h1 class="page-title">
        {{ $value['judul'] }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-add"
                        @if($value['route'] === 'rows') action="{{ route('voyager.rows.update', $row->id) }}"
                        @else action="{{ route('voyager.columns.update', $column->id) }}"
                        @endif
                        method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        {{ method_field("PUT") }}

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
                                    placeholder="{{ $value['placeNama'] }}"
                                    @if($value['route'] === 'rows') value="{{ $row->name }}"
                                    @else value="{{ $column->name }}"
                                    @endif>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="item">{{ $value['labelItem'] }}</label>
                                <table class="table table-bordered" id="dynamic_field">
                                    @foreach($items as $index => $val)
                                        <tr id="row{{ $index }}">
                                            <td class="col-md-10">
                                                <input type="text" name="item[]" id="item" class="form-control name_list"
                                                    placeholder="{{ $value['placeItem'] }}" value="{{ $val->name }}">
                                            </td>
                                            @if($index == 0)
                                                <td class="col-md-2 text-center" style="vertical-align:middle">
                                                    <input type="button" name="add" id="add"
                                                        class="btn btn-success btn_add" value="(+) Tambah Indikator">
                                                </td>
                                            @else
                                                <td class="col-md-2 text-center" style="vertical-align:middle">
                                                    <input type="button" name="remove" id="{{ $index }}"
                                                        class="btn btn-danger btn_remove" value="(x) Hapus Indikator">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
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

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>
                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
<script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row'+ i +'"><td><input type="text" name="item[]" id="item" class="form-control name_list" placeholder="{{ $value['placeItem'] }}"></td><td><input type="button" name="remove" id="'+ i +'" class="btn btn-danger btn_remove" value="x"></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row'+ button_id +'').remove();
        });
    });
</script>
@stop