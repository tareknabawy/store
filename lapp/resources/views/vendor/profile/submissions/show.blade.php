@extends('vendor.profile.layouts.app')
@section('content')
<div class="col-12 p-0">
    <div class="col-12 d-flex row m-0 " style="padding: 20px;">
        <div class="col-xs-12 col-md-6" style="padding:5px">
            <h3>My Submissions</h3>
        </div>
        <div class="col-xs-12 col-md-6 text-right" style="padding:5px;">
            <div class="d-inline-block " style="padding:15px 5px">  
                <a href="{{route('user.submit-app')}}" class="btn btn-success"><span class="fas fa-plus"></span> Submit New Application</a>
            </div>
        </div>
    </div>

    @php
    $submissions = \App\Submission::where('user_id',auth()->id())->orderBy('id','DESC')->paginate();
    @endphp

    <table class="table table-striped tabled-border table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Developer</th> 
                <th>Control</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
            <tr>
                <td>{{$submission->id}}</td>
                <td>{{$submission->title}}</td>
                <td><img src="{{env("APP_URL")}}/images/submissions/{{$submission->image}}" style="width:50px;height: 50px"></td>
                <td>{{$submission->developer}}</td>
                <td><a href="#"><span class="fas fa-search"></span></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-12 " style="padding:20px;">
        {{$submissions->links()}}
    </div>
</div>
@endsection