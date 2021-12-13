@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.account_settings'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" action="{{ route('accountsettings') }}">
                {{ csrf_field() }}

                <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{{ Auth::user()->email }}}"
                            placeholder="E-mail" />
                    </div>

                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                        <label>@lang('admin.current_password') <span class="text-danger">*</span></label>
                        <input id="current-password" type="password" class="form-control" name="current-password">

                    </div>

                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                        <label>@lang('admin.new_password')</label>
                        <input id="new-password" type="password" class="form-control" name="new-password">
                    </div>

                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                        <label>@lang('admin.confirm_new_password')</label>
                        <input id="new-password-confirm" type="password" class="form-control"
                            name="new-password_confirmation">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        @lang('admin.submit')
                    </button>
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