@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.ads'))

<!-- box -->
<div class="row">

    <!-- col -->
    <div class="col-md-12">

        @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
        @endif

        <!-- general form elements -->
        <div class="box">

            <!-- box-body -->
            <div class="box-body no-padding">
            
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th >ID</th>
                            <th >Name</th>
                            <th >Email</th>
                            <th >Power</th>
                            <th >Created At</th>
                            <th >Applications</th>
                            <th >Active</th>
                            <th >Control</th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->power}}</td>
                            <td>{{$user->created_at}}</td>
                            <td><a href="{{route('apps.index',['owner_id'=>$user->id])}}">{{$user->applications_count}}
                            </a></td>
                            <td>{!!$user->blocked=="1"?"<span class='fas fa-times text-danger'></span>":"<span class='fas fa-check-circle text-success'></span>"!!}</td>
                            <td>
                                @if($user->power!="ADMIN")
                                <form method="POST" action="{{route('user-block',$user)}}"> @csrf
                                    <button class="btn @if($user->blocked==1) btn-success @else btn-danger @endif" onclick="var result = confirm('Are You Sure ?');if(result){}else{event.preventDefault()}">@if($user->blocked==1) Active User @else Block User @endif</button></td>
                                </form>
                                @endif

                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <div class="col-12 p-3">
            {{$users->links()}}
        </div>
        <!-- /.general form elements -->

        @if($users->isEmpty())
        <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
        @endif

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection