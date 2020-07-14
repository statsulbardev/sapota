@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list-add"></i>
        Membuat Tabel Baru
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="custom-content">
        <!-- form start -->
        <form role="form"
            class="form-edit-add"
            action="{{ $edit ?
                route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) :
                route('voyager.'.$dataType->slug.'.store') }}"
            method="POST" enctype="multipart/form-data">

            <!-- PUT Method if we are editing -->
            @if($edit)
                {{ method_field("PUT") }}
            @endif

            <!-- CSRF TOKEN -->
            {{ csrf_field() }}

            <hr style="border:1px solid #E4E4E4">

            <div class="row">
                <div class="right-padding col-md-4">
                    <p class="control-label">Judul Tabel</p>
                    <div style="text-align:justify">
                        <span class="plain-label">Isikan judul tabel sesuai dengan data yang akan dimasukkan.</span>
                    </div>
                </div>
                <div class="sized-padding col-md-8">
                    <div class="custom-panel-body panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Adding / Editing -->
                        @php
                            $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                        @endphp

                        {{-- section pertama --}}
                        @foreach($dataTypeRows as $row)
                            <!-- GET THE DISPLAY OPTIONS -->
                            @php
                                $display_options = $row->details->display ?? NULL;
                                if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                    $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                }
                            @endphp

                            @if (isset($row->details->legend) && isset($row->details->legend->text))
                                <legend class="text-{{ $row->details->legend->align ?? 'center' }}"
                                    style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};
                                    padding: 5px;">
                                    {{ $row->details->legend->text }}
                                </legend>
                            @endif

                            @if($row->field === 'name' )
                                <div class="custom-form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    {{ $row->slugify }}
                                    <label class="control-label" for="name">{{ $row->display_name }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if (isset($row->details->view))
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add')])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                @php
                                    continue;
                                @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <hr style="border:1px solid #E4E4E4">

            <div class="row">
                <div class="right-padding col-md-4">
                    <p class="control-label">Komponen Tabel</p>
                    <div style="text-align:justify">
                        <span class="plain-label">Tabel merupakan sarana untuk membandingkan antar variabel
                            yang ingin ditampilkan. Adapun penyusun tabel merupakan variabel yang dibentuk dalam dimensi
                            baris dan kolom.</span>
                    </div>
                </div>
                <div class="sized-padding col-md-8">
                    <div class="custom-panel-body panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Adding / Editing -->
                        @php
                            $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                        @endphp

                        {{-- section kedua --}}
                        @foreach($dataTypeRows as $row)
                            <!-- GET THE DISPLAY OPTIONS -->
                            @php
                                $display_options = $row->details->display ?? NULL;
                                if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                    $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                }
                            @endphp

                            @if (isset($row->details->legend) && isset($row->details->legend->text))
                                <legend class="text-{{ $row->details->legend->align ?? 'center' }}"
                                    style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};
                                    padding: 5px;">
                                    {{ $row->details->legend->text }}
                                </legend>
                            @endif

                            @if($row->field === 'template_belongsto_row_relationship' ||
                                $row->field === 'template_belongstomany_column_relationship')
                                <div class="custom-form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    {{ $row->slugify }}
                                    <label class="control-label" for="name">{{ $row->display_name }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if (isset($row->details->view))
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add')])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                @php
                                    continue; // jika bukan admin jangan tampilkan assign user dan utama
                                @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            @if(Auth::user()->role_id === 1)
                <hr style="border:1px solid #E4E4E4">

                <div class="row">
                    <div class="right-padding col-md-4">
                        <p class="control-label">Instansi Terkait</p>
                        <div style="text-align:justify">
                            <span class="plain-label">Tentukan instansi mana yang akan bertanggung jawab dalam mengisi tabel
                                yang dibuat. Tentukan juga apakah tabel tersebut merupakan tabel utama yang wajib
                                dilaporkan secara rutin atau opsional saja.</span>
                        </div>
                    </div>
                    <div class="sized-padding col-md-8">
                        <div class="custom-panel-body panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            {{-- section ketiga --}}
                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                @endphp

                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                @if($row->field === 'template_belongsto_user_relationship' || $row->field === 'main')
                                    <div class="custom-form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label class="control-label" for="name">{{ $row->display_name }}</label>
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if (isset($row->details->view))
                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add')])
                                        @elseif ($row->type == 'relationship')
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif

                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    @php
                                        continue; // jika bukan admin jangan tampilkan assign user dan utama
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif (Auth::user()->role_id === 3)
                <hr style="border:1px solid #E4E4E4">

                <div class="row">
                    <div class="right-padding col-md-4">
                        <p class="control-label">Instansi Terkait</p>
                        <div style="text-align:justify">
                            <span class="plain-label">Tentukan instansi mana yang akan bertanggung jawab dalam mengisi tabel
                                yang dibuat. Tentukan juga apakah tabel tersebut merupakan tabel utama yang wajib
                                dilaporkan secara rutin atau opsional saja.</span>
                        </div>
                    </div>
                    <div class="sized-padding col-md-8">
                        <div class="custom-panel-body panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            {{-- section ketiga --}}
                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                @endphp

                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                @if($row->field === 'template_belongsto_user_relationship')
                                    <div class="custom-form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label class="control-label" for="name">{{ $row->display_name }}</label>
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if (isset($row->details->view))
                                            @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add')])
                                        @elseif ($row->type == 'relationship')
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif

                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        @if ($errors->has($row->field))
                                            @foreach ($errors->get($row->field) as $error)
                                                <span class="help-block">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    @php
                                        continue; // jika bukan admin jangan tampilkan assign user dan utama
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <hr style="border:1px solid #E4E4E4">

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="simpan btn btn-primary save">
                        {{ __('voyager::generic.save') }}
                    </button>
                </div>
            </div>
        </form>
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
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop