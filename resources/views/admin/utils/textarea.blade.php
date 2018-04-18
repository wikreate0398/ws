<div class="form-group">
	<label class="control-label">{{ $label }}</label> 
	<textarea name="{{ $name }}" class="form-control {{ !empty($ckeditor) ? 'ckeditor' : '' }}">{{ !empty($value) ? $value : '' }}</textarea>
	@if(!empty($help))
		<span class="help-block">{{ $help }}</span>
	@endif
</div>