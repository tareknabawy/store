@extends('vendor.profile.layouts.app')
@section('content')
<div class="col-12 col-lg-6 row" style="padding: 5px;margin: 0px;">
    <div class="col-xs-12 col-lg-6 " style="padding: 5px;">
    	<div class="col-xs-12 row" style="padding: 0px;background: #fff;margin: 0px;display: flex;align-items: center;border-radius: 8px 20px 8px 20px;">
    		<div style="width:60px;padding: 20px;">
    			<span class="fas fa-pallet " style="font-size: 28px;color:#222d32"></span>
    		</div>
    		<div style="width:calc(100% - 60px);padding: 20px;">
    			<div class="" style="font-size: 20px;color:#222d32;">Submissions</div>
    			<div class="" style="font-size: 28px;color:#009688;font-weight: bold;">{{\App\Submission::where('user_id',auth()->user()->id)->count()}}</div>
    		</div>
    	</div>
    </div>
    <div class="col-xs-12 col-lg-6" style="padding: 5px;">
    	<div class="col-xs-12 row" style="padding: 0px;background: #fff;margin: 0px;display: flex;align-items: center;border-radius: 8px 20px 8px 20px;">
    		<div style="width:60px;padding: 20px;">
    			<span class="fas fa-box-open  " style="font-size: 28px;color:#222d32"></span>
    		</div>
    		<div style="width:calc(100% - 60px);padding: 20px;">
    			<div class="" style="font-size: 20px;color:#222d32;">Applications</div>
    			<div class="" style="font-size: 28px;color:#009688;font-weight: bold;">{{\App\Application::where('owner_id',auth()->user()->id)->count()}}</div>
    		</div>
    	</div>
    </div>
    <div class="col-xs-12 col-lg-6" style="padding: 5px;">
    	<div class="col-xs-12 row" style="padding: 0px;background: #fff;margin: 0px;display: flex;align-items: center;border-radius: 8px 20px 8px 20px;">
    		<div style="width:60px;padding: 20px;">
    			<span class="fas fa-search  " style="font-size: 28px;color:#222d32"></span>
    		</div>
    		<div style="width:calc(100% - 60px);padding: 20px;">
    			<div class="" style="font-size: 20px;color:#222d32;">Search</div>
    			<div class="" style="font-size: 28px;color:#009688;font-weight: bold;">{{\App\Application::where('owner_id',auth()->user()->id)->sum('hits')}}</div>
    		</div>
    	</div>
    </div>
        <div class="col-xs-12 col-lg-6" style="padding: 5px;">
    	<div class="col-xs-12 row" style="padding: 0px;background: #fff;margin: 0px;display: flex;align-items: center;border-radius: 8px 20px 8px 20px;">
    		<div style="width:60px;padding: 20px;">
    			<span class="fas fa-download  " style="font-size: 28px;color:#222d32"></span>
    		</div>
    		<div style="width:calc(100% - 60px);padding: 20px;">
    			<div class="" style="font-size: 20px;color:#222d32;">Downloads</div>
    			<div class="" style="font-size: 28px;color:#009688;font-weight: bold;">{{\App\Application::where('owner_id',auth()->user()->id)->sum('counter')}}</div>
    		</div>
    	</div>
    </div>
    
    
</div>


<div class="col-xs-12 row" style="padding: 5px;text-align: center;margin: 0px;">
	<div class="col-12 col-lg-6 row" style="padding: 50px 0px;margin: 0px;">
		<div class="row text-center " style="padding: 0px;margin: 0px;display: flex;align-items: center; width: 200px;display: inline-block;">
			<a href="#" data-toggle="modal" data-target="#new-submission-modal">
				<img src="{{asset('/assets/undraw_add_files_re_v09g.svg')}}" style="width:100%;filter: grayscale(100%);transition: .2s all ease-in-out;border-radius:5px;padding: 15px;" class="submit-app">
			</a>
		</div>
	</div>
</div>
<style type="text/css">
	.submit-app:hover{
		filter: grayscale(0%)!important;
		box-shadow: 1px 10px 5px #ddd;
	}
</style>
@endsection 