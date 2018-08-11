<div class="form-group">
	<label class="control-label col-md-12">
		{{ $label }} 
		@if($req)
			<span class="req">*</span>
		@endif 
	</label>
	<div class="col-md-12"> 
		<select name="{{ $name }}" class="form-control">
			<option value="">Выбрать</option>
			@foreach($data as $item)
				@php $selected = (@$value == $item['id']) ? 'selected' : '';  @endphp
				<option {{ $selected }} value="{{ $item['id'] }}">{{ $item['name'] }}</option>
			@endforeach
		</select>
		@if(!empty($help))
			<span class="help-block">{{ $help }}</span>
		@endif
	</div>
</div>