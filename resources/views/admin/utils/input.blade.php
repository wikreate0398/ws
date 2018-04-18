<div class="form-group">
	<label class="control-label">{{ $label }}</label>
	<input type="text" class="form-control" placeholder="" value="{{ !empty($value) ? $value : '' }}" name="{{ $name }}">
	@if(!empty($help))
		<span class="help-block">{{ $help }}</span>
	@endif
</div>