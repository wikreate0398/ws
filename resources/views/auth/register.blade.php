@extends('layouts.app')

@section('content')
    <div class="container no__home">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="header_block">Регистрация</h2>
                <ul class="nav nav-tabs registration_type" role="tablist">
                    <li role="presentation" class="active">
						<a href="#user" aria-controls="user" role="tab" data-toggle="tab">Ученик</a>
					</li>
                    <li role="presentation">
						<a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">Учитель </a>
                    </li>
                    <li role="presentation">
						<a href="#university" aria-controls="university" role="tab" data-toggle="tab">Учебное заведение</a>
					</li>
                </ul>
                <div class="tab-content tab_registration">
                    <div role="tabpanel" class="tab-pane active" id="user">
                        <form class="form-horizontal ajax__submit" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_type" value="1">
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">ФИО <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="name" value="" required autofocus>
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
                                <div class="col-md-12">
									<div class="btn_form">
										<p>Нажимая кнопку «Зарегистрироваться», Вы принимаете условия <a href="">Пользовательского соглашения</a> и <a href="">политики конфиденциальности</a> нашего портала</p>
										<button type="submit" class="btn btn-primary btn_registration">
											Зарегистрироваться
										</button>
									</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="teacher">
                        <form class="form-horizontal ajax__submit" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_type" value="2">
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">ФИО <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="name" value="" required autofocus>
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
                                <div class="col-md-12">
									<div class="btn_form">
										<p>Нажимая кнопку «Зарегистрироваться», Вы принимаете условия <a href="">Пользовательского соглашения</a> и <a href="">политики конфиденциальности</a> нашего портала</p>
										<button type="submit" class="btn btn-primary btn_registration">
											Зарегистрироваться
										</button>
									</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="university"> 

                        <form class="form-horizontal ajax__submit" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_type" value="3">
                               
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">НАЗВАНИЕ УЧЕБНОГО ЗАВЕДЕНИЯ/ЦЕНТРА <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="name" value="" required autofocus>
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
                                <div class="col-md-12 text-center">
									<div class="btn_form">
										<p>Нажимая кнопку «Зарегистрироваться», Вы принимаете условия <a href="">Пользовательского соглашения</a> и <a href="">политики конфиденциальности</a> нашего портала</p>
										<button type="submit" class="btn btn-primary btn_registration">
											Зарегистрироваться 
										</button>
									</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
