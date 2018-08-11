<div class="form-group">
	<label class="control-label col-md-12">{{ $label }}</label> 
	<div class="col-md-12"> 
		<textarea name="{{ $name }}" 
		          @if(@$maxlength) maxlength="{{ $maxlength }}" @endif 
		          class="form-control {{ !empty($ckeditor) ? 'ckeditor' : '' }}">{{ !empty($value) ? $value : '' }}</textarea>
		@if(!empty($help))
			<span class="help-block">{{ $help }}</span>
		@endif
		@if(!empty($maxlength))
		<div class="maxlength__label"><span>0</span> символов ({{ $maxlength }} максимум)</div>
		@endif
	</div>
</div>