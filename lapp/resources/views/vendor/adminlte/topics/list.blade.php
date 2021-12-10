@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.topics'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
        @endif

        @foreach ($apps as $app)
        @php $app_title[$app->id]=$app->title; @endphp
        @php $app_image[$app->id]=$app->image; @endphp
        @endforeach

        <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" action="{{action('TopicItemController@update', $id)}}">
                @csrf @method('PUT')

                <!-- box-body -->
                <div class="box-body no-padding">

                    <div class="table-responsive">
                        <table class="table table-striped" id="table" data-delete-prompt="@lang('admin.delete_prompt')"
                            data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')"
                            data-delete="@lang('admin.delete')" data-app-title="@lang('admin.app_title')">
                            <thead>
                                <tr>
                                    <th class="col-md-1">@lang('admin.image')</th>
                                    <th class="col-md-11">@lang('admin.app_title')</th>
                                </tr>
                            </thead>
                            <tbody class="sortable-topics">
                                
                                @if (count($item_list) >= 1)
                                @foreach($item_list as $key => $row)
                                @if (!empty($app_title[$row]))

                                @if(empty($app_image[$row]))
                                @php $app_image[$row]='no_image.png'; @endphp
                                @endif

                                <tr class='topic_list' id="{{ $key }}">
                                    <td><img src="{{ asset("images/$app_image[$row]") }}" id='img_{{ $key }}'
                                            class="img-w100"></td>
                                    <td><input type='text' onclick='this.focus(); this.select()'
                                            class='topiclist form-control' id='topiclist_{{ $key }}'
                                            placeholder='@lang(' admin.app_title')'
                                            value="{{ $app_title[$row] }}"><input type='button' value='@lang('admin.delete')' class="btn btn-sm bg-red mt-5 _delete_topic"
                                            id='remove'><input type='hidden' class='appid' id='appid_{{ $key }}'
                                            name="appid_{{ $key }}" value="{{ $row }}"></td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr class='topic_list' id="1">
                                    <td><img src="{{ asset("images/no_image.png") }}" id='img_1' class="img-w100"></td>
                                    <td><input type='text' onclick='this.focus(); this.select()'
                                            class='topiclist form-control' id='topiclist_1' placeholder='@lang('admin.app_title')'><input type='button' value='@lang('admin.delete')'
                                            class='btn btn-sm bg-red mt-5 _delete_topic' id='remove'><input
                                            type='hidden' class='appid' id='appid_1' name="appid_1"></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <input type='button' value='@lang('admin.add_more')' class="btn bg-orange" id='addmore'> <button
                        type="submit" class="btn btn-primary">@lang('admin.submit')</button>
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