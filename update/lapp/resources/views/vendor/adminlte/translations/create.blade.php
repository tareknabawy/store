@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.create_translation'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif @if(Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
        </div>
        @endif

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/translations')}}">
                @csrf @method('POST')

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.language') <span class="text-danger">*</span></label>
                        <input type="text" name="language" class="form-control"
                            placeholder="@lang('admin.language')" />
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.language_code') <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control"
                            placeholder="@lang('admin.language_code')" />
                    </div>
                    
                    <div class="form-group">
                        <label>@lang('admin.og_locale_tag') <span class="text-danger">*</span></label>
                        <input type="text" name="locale_code" class="form-control"
                            placeholder="@lang('admin.og_locale_tag')" />
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                </div>

            </form>
            <!-- /.form -->

        </div>
        <!-- /.general form elements -->

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection