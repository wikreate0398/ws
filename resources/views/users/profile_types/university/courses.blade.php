
<a href="{{ route('add_course') }}" class="btn btn-info  " style="display: inline-block; width: auto; border-radius: 20px;">Добавить свой курс</a>
<br><br>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
    	<a href="#active" aria-controls="active" role="tab" data-toggle="tab">АКТИВНЫЕ</a>
    </li>
    <li role="presentation">
    	<a href="#finish" aria-controls="finish" role="tab" data-toggle="tab">ЗАВЕРШЕННЫЕ</a>
    </li> 
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="active" style="padding-top: 20px;">
		Активные курсы
	</div>

	<div role="tabpanel" class="tab-pane" id="finish" style="padding-top: 20px;">
		Завершенные курсы
	</div>
</div>