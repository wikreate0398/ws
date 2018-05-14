<div class="col-md-6">
	<div class="form-group">
		<input type="text" class="form-control" value="{{ @$education['institution_name'] }}" name="education[institution][]" placeholder="Образовательное учреждение">
		<!-- <select class="form-control">
		  <option>Список всех ВУЗОВ</option>
		</select> -->
	</div>
</div> 
<div class="col-md-6">
	<div class="form-group select_form">
		<select class="form-control" name="education[grade][]">
		  <option value="0">Уровень образования</option>
		    @foreach($grade_education as $item)
                @if(!empty($item['childs']))
                    <optgroup label="{{$item['name']}}">
                        @foreach($item['childs'] as $child)
                            <option {{ (@$education['grade'] == $child['id']) ? 'selected' : '' }} value="{{$child['id']}}">{{$child['name']}}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option {{ (@$education['grade'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                        {{$item['name']}}
                    </option>
                @endif
            @endforeach
		</select>
	</div>
</div>
<div class="col-md-12">
	<button class="btn btn-sm btn-dafault add__more" 
	        onclick="addBlock('education__container');" 
	        type="button">
	    + Добавить еще
	</button>
</div>