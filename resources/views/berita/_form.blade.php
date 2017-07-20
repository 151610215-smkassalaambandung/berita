<div class="form-group{{$errors->has('judul') ? 'has-error' : ''}}">
	{!! Form::label('judul','judul',['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('judul', null,['class'=>'form-control']) !!}
		{!! $errors->first('judul','<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group{!! $errors->has('kategori_id') ? 'has-error' : '' !!}">
	{!! Form::label('kategori_id','Kategori Berita',['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-4">
		{!! Form::select('kategori_id',[''=>'']+App\Kategori::pluck('name','id')->all(), null,['class'=>'js-selectize','placeholder'=>'pilih kategori']) !!}
		{!! $errors->first('kategori_id','<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group{{$errors->has('isi_berita') ? 'has-error' : ''}}">
	{!! Form::label('isi_berita','Isi Berita',['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-4">
		{!! Form::textarea('isi_berita', null,['class'=>'form-control']) !!}
		{!! $errors->first('isi_berita','<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group{{$errors->has('cover') ? 'has-error' : ''}}">
	{!! Form::label('cover','Gambar',['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-4">
		{!! Form::file('cover') !!}
		@if(isset($berita)&& $berita->cover)
		<p>
			{!! Html::image(asset('img/'.$berita->cover), null,['class'=>'img-rounded img-responsive']) !!}
		</p>
		@endif
		{!! $errors->first('cover','<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group">
	<div class="col-md-4 col-md-offset-2">
		{!! Form::submit('Simpan',['class'=>'btn btn-primary']) !!}
	</div>
</div>