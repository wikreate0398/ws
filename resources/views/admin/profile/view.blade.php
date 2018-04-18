@extends('layouts.admin')

@section('content') 
	<div class="row">
    <div class="col-md-12">
	
		<button class="btn btn-primary btn-sm" onclick="$('.hide__container').slideToggle();" style="margin-bottom: 20px;">
			<i class="fa fa-user" aria-hidden="true"></i> Добавить пользователя
		</button> 

        <div class="portlet light bordered hide__container" style="display: none;">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject">Добавить пользователя</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="/admin/profile/addNewUser" method="POST" class="form-horizontal ajax__submit">

                	{{ csrf_field() }}

                    <div class="form-body">
                    	<div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Имя</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

	                    <div class="form-group">
	                        <label for="" class="col-lg-2 col-sm-2 control-label">Логин/E-mail</label>
	                        <div class="col-lg-10">
	                            <input type="text" class="form-control" name="email">
	                        </div>
	                    </div>
                     
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Тип</label>
                            <div class="col-lg-10">
                                <label for="type_1">
                                    <input type="radio" id="type_1" name="type" value="2" checked>Менеджер</label>
                                <label for="type_2">
                                    <input type="radio" id="type_2" name="type" value="1"> Администартор</label>
                            </div>
                        </div>

                        <style>
                            .radio {
                                padding-top: 0px !important;
                                height: auto !important;
                            }
                        </style>
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Новый пароль</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Повторите пароль</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </div>
                    </div>
                </form> 
                <!-- END FORM-->
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject">Персональные данные</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="/admin/profile/edit" class="form-horizontal ajax__submit" method="POST">

                	{{ csrf_field() }}

                    <div class="form-body">
                         
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Логин/E-mail</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="disabledInput" value="{{ Auth::user()->email }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Имя</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Новый пароль</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-2 control-label">Повторите пароль</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div> 

@if(count($users))
<div class="row">
	<div class="col-md-12">
		<h3 class="form-section">Пользователи</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Имя</th>
					<th>Логин</th>
					<th>Тип</th>
					<th style="width: 150px;"><i class="fa fa-cogs" aria-hidden="true"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ ucfirst($user['name']) }}</td>
						<td>{{ ucfirst($user['email']) }}</td>
						<td>
							{{ ($user['login'] == 1) ? 'Администартор' :  'Менеджер' }}
						</td>
						<td>
							<input type="checkbox" 
	          		       class="make-switch" data-size="mini" {{ !empty($user['active']) ? 'checked' : '' }} 
	          		       data-on-text="<i class='fa fa-check'></i>" 
	          		       data-off-text="<i class='fa fa-times'></i>" 
	          		       onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $user->id }}', 'active')">  
			             	<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal{{ $user['id'] }}">Удалить</a>  
			            	<!-- Modal -->
			            		@include('admin.utils.delete', ['id' => $user['id'], 'table' => $table])
			           		<!-- Modal --> 
							</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endif
@stop