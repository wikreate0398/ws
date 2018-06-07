@extends('layouts.admin')
 
@section('content') 
<div class="row">
	<div class="col-md-12">
		<form action="/admin/user/fastRegister" class="form-horizontal ajax__submit" data-redirect="{{ route('admin_user_teacher') }}"> 
            {{ csrf_field() }} 

            <input type="hidden" name="user_type" value="2">

            <div class="row" style="padding-top:20px;">
    
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">ФИО <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name" value=""
                                   required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                        
                    <div class="form-group">
                        <label class="col-md-12 control-label">E-mail <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" value=""
                                   required>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="col-md-12 control-label">Пароль <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password"
                                   value="" required>
                        </div>
                    </div>
 
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="col-md-12 control-label">Номер телефона <span class="req">*</span>

                        </label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="phone" value=""
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Подтверждение пароля
                            <span class="req">*</span>
                        </label>
                        <div class="col-md-12">
                            <input type="password" class="form-control"
                                   name="password_confirmation" value="" required>
                        </div>
                    </div>
                    
                </div>
                 
            </div>
            <div class="form-group">
                <div class="col-md-12" id="error-respond"></div>
                <div class="col-md-6 ">
                    <button type="submit" class="btn btn-primary">
                        Создать
                    </button>
                </div>
            </div>
        </form>
	</div>
</div>

@stop
