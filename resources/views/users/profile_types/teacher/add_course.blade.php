<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
    	<a href="#about" aria-controls="about" role="tab" data-toggle="tab">О курсе</a>
    </li>
    <li role="presentation">
    	<a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Настройки курса</a>
    </li> 
    <li role="presentation">
    	<a href="#programm" aria-controls="programm" role="tab" data-toggle="tab">Программа курса</a>
    </li> 
</ul>

<form class="form-horizontal ajax__submit" method="POST" action="{{ route('save_course') }}">
	 {{ csrf_field() }}
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="about" style="padding-top: 20px;">
		
		<div class="form-group">
            <label class="col-md-12 control-label">Название курса <span class="req">*</span></label>
            <div class="col-md-12">
                <input type="text" class="form-control" name="name" value="" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Краткое описание курса <span class="req">*</span></label>
            <div class="col-md-12">
            	<textarea name="description" class="form-control" placeholder="200" required></textarea> 
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Подробное описание курса</label>
            <div class="col-md-12">
            	<textarea name="text" class="form-control" placeholder="2000"></textarea> 
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Куратор курса <span class="req">*</span></label>
            <div class="col-md-12">
                <input type="text" 
                       class="form-control" 
                       name="" 
                       value="{{ Auth::user()->name }} {{ Auth::user()->surname }} {{ Auth::user()->patronymic }}" 
                       required
                       disabled>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Категория и подкатегория <span class="req">*</span></label>
            <div class="col-md-12">
                <select name="id_category"  class="form-control" onchange="loadCourseSubcats(this)">
                    <option value="">Выбрать</option>
                    @foreach($categories as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12" id="load__subcats" style="display: none; margin-top: 20px;"> 
            </div>
        </div>

        <h2 style="font-size: 24px; margin-top: 40px;">Цены и скидки <span class="req">*</span></h2>
		
		 
	        <div class="form-check">
		        <input type="radio" name="pay" value="1" onchange="setPayCourse(this)" class="form-check-input" id="exampleCheck1">
		        <label class="form-check-label" for="exampleCheck1">Бесплатный курс</label>
		  	</div> 

	      	<div class="form-check">
	        	<input type="radio" name="pay" value="2" onchange="setPayCourse(this)" class="form-check-input" id="exampleCheck2">
	        	<label class="form-check-label" for="exampleCheck2">Платный курс</label>
	      	</div>
	      	<br>
	       	<input type="text" class="form-control price__course" name="price" value="" placeholder="Стоимость, руб *" required disabled>
       
	</div>

	<div role="tabpanel" class="tab-pane" id="settings" style="padding-top: 20px;">
		<div class="col-md-12">
            <div class="form-group">
                <label class="col-md-12 control-label" style="white-space: nowrap;">Запись курса открыта до <span class="req">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control datepicker" name="is_open_until" value="" placeholder="DD/MM/YY" required>
                </div>
            </div> 
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-12 control-label" style="white-space: nowrap;">Доступность на сайте <span class="req">*</span></label>
                <div class="col-md-9"> 
                    <div class="form-check">
				        <input type="radio" name="available" value="1" class="form-check-input" id="exampleCheck11">
				        <label class="form-check-label" for="exampleCheck11">Всем желающим</label>
				  	</div>
			      	<div class="form-check">
			        	<input type="radio" name="available" value="2" class="form-check-input" id="exampleCheck22">
			        	<label class="form-check-label" for="exampleCheck22">Только для зарегистрированных пользователей</label>
			      	</div>
			      	<div class="form-check">
				        <input type="radio" name="available" value="3" class="form-check-input" id="exampleCheck33">
				        <label class="form-check-label" for="exampleCheck33">Скрыть курс по окончанию набора</label>
				  	</div>  
                </div>
            </div> 
        </div>
	</div>

	<div role="tabpanel" class="tab-pane" id="programm" style="padding-top: 20px;">
	
		<div class="course__sections"> 

				<div class="panel panel-default course__section first_block">
			        <div class="panel-heading">
			            <h3 class="panel-title">Раздел</h3>
			        </div>
			        <div class="panel-body"> 
			            <div class="row">
			                <div class="col-md-12">
                     
					            <div class="form-group">
					                <label class="col-md-12 control-label" style="white-space: nowrap;">Название Раздела<span class="req">*</span></label>
					                <div class="col-md-9">
					                    <input type="text" class="form-control" name="section[name][]" value="" placeholder="" required>
					                </div>
					            </div> 

					            <div class="lecture__sections"> 
						            <div class="panel panel-warning lecture__section first_block">
						            	<div class="panel-heading">
								            <h3 class="panel-title">Добавления лекции</h3>
								        </div>
						            	<div class="panel-body"> 
						            		<div class="form-group">
									            <label class="col-md-12 control-label">Название лекции <span class="req">*</span></label>
									            <div class="col-md-12">
									                <input type="text" class="form-control" name="lecture[name][]" value="" required>
									            </div>
									        </div>

									        <div class="form-group">
									            <label class="col-md-12 control-label">Описание лекции <span class="req">*</span></label>
									            <div class="col-md-12">
									            	<textarea name="lecture[description][]" class="form-control" placeholder="" required=""></textarea> 
									            </div>
									        </div>

									        <div class="form-group">
									            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
									            <div class="col-md-2">
									            	<input type="text" class="form-control number_field" name="lecture[hourse][]" placeholder="чч" value="" required>
									            </div>
									            <div class="col-md-2">
									            	<input type="text" class="form-control number_field" name="lecture[minutes][]" placeholder="мм" value="">
									            </div>
									        </div>
						            	</div>
						            </div>
					            </div>
			         
			                </div> 
			 
			                <div class="col-md-12">
			                    <button type="button" onclick="addLecture(this);" class="btn btn-sm btn-dafault add__more">
			                    	Добавить лекцию
			                    </button>
			                </div> 			            
			            </div> 
			        </div>
    			</div>
 
		</div>

		<button class="btn btn-default btn-sm" type="button" onclick="addCourseSection()">Добавить раздел</button>
	</div>
</div>
<div style="margin-top: 30px;">
	<div id="error-respond"></div>
	<button type="submit" class="btn btn-success" style="display: inline-block; width: auto;">
	    Добавить 
	</button>
</div>

</form> 

<script>

	$('form').find('input').each(function(){
        $(this).removeAttr('required');
    });

    $('form').find('textarea').each(function(){
        $(this).removeAttr('required');
    }); 

	function addLecture(){
		var first_block = $('.lecture__sections .lecture__section.first_block');
	    var cloneBlock = $(first_block).clone();
	    $(cloneBlock).removeClass('first_block');
	    $(cloneBlock).removeClass('error__input');
	     
	    $(cloneBlock).append('<div class="close__item" onclick="deleteLectureBlock(this);">X</div>');
	    $(cloneBlock).find('input').val('');
	    $(cloneBlock).find('textarea').val(''); 
	    $(cloneBlock).find('select option').prop('selected', false);
	    $(cloneBlock).find('select option:first').prop('selected', true);
	    $(cloneBlock).find('input.id__block').remove();

	    $(cloneBlock).find('select').each(function(){
	        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
	    });

	    $(cloneBlock).find('input').each(function(){
	        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
	    });

	    $(cloneBlock).find('textarea').each(function(){
	        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
	    }); 
	  
	    $(cloneBlock).insertAfter('.lecture__sections .lecture__section:last'); 
	}

	function addCourseSection()
	{ 
	    var first_block = $('.course__sections .course__section.first_block');
	    var cloneBlock = $(first_block).clone();
	    $(cloneBlock).removeClass('first_block');
	    $(cloneBlock).removeClass('error__input');
	     
	    $(cloneBlock).append('<div class="close__item" onclick="deleteSectionBlock(this);">X</div>');
	    $(cloneBlock).find('input').val('');
	    $(cloneBlock).find('textarea').val(''); 
	    $(cloneBlock).find('select option').prop('selected', false);
	    $(cloneBlock).find('select option:first').prop('selected', true);
	    $(cloneBlock).find('input.id__block').remove();

	    $(cloneBlock).find('select').each(function(){
	        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
	    });

	    $(cloneBlock).find('input').each(function(){
	        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
	    });

	    $(cloneBlock).find('textarea').each(function(){
	        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
	    }); 

	    $(cloneBlock).find('.lecture__section').not('.first_block').remove();
	  
	    $(cloneBlock).insertAfter('.course__sections .course__section:last'); 
	}

	function deleteSectionBlock(item){
	    $(item).closest('.course__section').remove();
	}

	function deleteLectureBlock(item){
	    $(item).closest('.lecture__section').remove();
	}	 

	function loadCourseSubcats(select){  
        $( "#load__subcats").load( "/user/profile/loadCourseSubcats",{id: $(select).val(), _token: CSRF_TOKEN}, function( response, status, xhr ) { 
          	if ( response == "" ) {
            	$('#load__subcats').hide();
            	$('#load__subcats').html('');
           	}else{
            	$('#load__subcats').show();
        	}
      	});
	}

	function setPayCourse(input){
		var val = $(input).val();
		if (val == 1) {
			$('.price__course').attr('disabled', true);
		}else{
			$('.price__course').attr('disabled', false);
		} 
	}
</script>

<style>
	.form-check label{
		font-weight: 400;
	}

	.course__section, .lecture__section{
		position: relative;
	}
</style>