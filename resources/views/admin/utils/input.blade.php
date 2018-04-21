<div class="form-group">
	<label class="control-label col-md-12">{{ $label }}</label>
	<div class="col-md-12"> 
	<input type="text" class="form-control" placeholder="" value="{{ !empty($value) ? $value : '' }}" name="{{ $name }}">
	@if(!empty($help))
		<span class="help-block">{{ $help }}</span>
	@endif
	</div>
</div>