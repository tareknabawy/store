@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.category_settings'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
        @endif

        @foreach (json_decode($crawler_categories) as $key => $value)
        @php $all_cat=json_decode($crawler_categories); @endphp
        @php $crawler_category_setting[$key]=$value; @endphp
        @endforeach

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" action="{{url('/admin/scraper_categories')}}">
                @csrf @method('POST')

                <!-- box-body -->
                <div class="box-body">

                    <!-- row -->
                    <div class="row">

                        @foreach($app_categories as $id => $row )

                        @if ( !property_exists($all_cat,$row) )
                        @php $crawler_category_setting[$row] = '0'; @endphp
                        @endif

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{$row}}</label>
                                <select title="@lang('admin.select_category')" name="{{$row}}"
                                    class="form-control selectpicker" data-live-search="true">
                                    <option value="0">Select Category</option>
                                   @foreach($categories as $category)
                                    <option data-icon="{{ $category->fa_icon }}" value="{{ $category->id }}"
                                        {{ $crawler_category_setting[$row] == $category->id ? ' selected' : '' }}>{{ $category->title }}
                                    </option>
                                    <?php echo $crawler_category_setting[$row]; ?>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!-- /.row -->

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