@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="{{url('/home')}}">Dasboard</a></li>
				<li><a href="{{url('/admin/berita')}}">Berita</a></li>
				<li class="active">Tambah Berita</li>
				</ul>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Tambah Berita</h2>
					</div>
					<div class="panel-body">
						{!! Form::open(['url'=>route('berita.store'),
						'method'=>'post','files'=>'true','class'=>'form-horizontal']) !!}
						@include('berita._form')
						{!! Form::close() !!}
					</div>
				</div>
				</div>
				</div>
				</div>
@endsection