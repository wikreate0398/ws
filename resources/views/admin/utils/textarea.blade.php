<div class="form-group">
	<label class="control-label col-md-12">{{ $label }}</label> 
	<div class="col-md-12"> 
		<textarea name="{{ $name }}" class="form-control {{ !empty($ckeditor) ? 'ckeditor' : '' }}">{{ !empty($value) ? $value : '' }}</textarea>
		@if(!empty($help))
			<span class="help-block">{{ $help }}</span>
		@endif
	</div>
</div>