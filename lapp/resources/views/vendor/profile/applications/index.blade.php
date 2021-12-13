@extends('vendor.profile.layouts.app')
@section('content')
<div class="col-12 p-0">
    <div class="col-12 d-flex row m-0 " style="padding: 20px;">
        <div class="col-xs-12 col-md-6" style="padding:5px">
            <h3>My Applications</h3>
        </div>
        <div class="col-xs-12 col-md-6 text-right" style="padding:5px;">
            <div class="d-inline-block " style="padding:15px 5px">  
                <a href="#" class="btn btn-success"  data-toggle="modal" data-target="#new-submission-modal" ><span class="fas fa-plus"></span> Submit New Application</a>
            </div>
        </div>
    </div>

    @php
    $applications = \App\Application::where('owner_id',auth()->id())->orderBy('id','DESC')->paginate();
    @endphp

    <table class="table table-striped tabled-border table-hover" style="background: #fff;">
        <thead>
            <tr>
                <th style="padding:15px 10px">ID</th>
                <th style="padding:15px 10px">Name</th>
                <th style="padding:15px 10px">Image</th>
                <th style="padding:15px 10px">Developer</th> 
                <th style="padding:15px 10px">Control</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
            <tr>
                <td>{{$application->id}}</td>
                <td>{{$application->title}}</td>
                <td><img src="{{env("APP_URL")}}/images/{{$application->image}}" style="width:50px;height: 50px"></td>
                <td>{{$application->developer}}</td>
                <td>
                    <a href="{{route('app.show',$application->slug)}}" target="_blank"><span class="fas fa-search"></span></a>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-12 " style="padding:20px;">
        {{$applications->links()}}
    </div>
</div>
@endsection