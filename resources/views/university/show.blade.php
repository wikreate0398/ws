@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">
        <div class="col-md-12 form-horizontal">
            <h1>{{ $data['full_name'] }}</h1>
 
               
            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label class="col-md-12 control-label">Тип </label>
                        <div class="col-md-12"> 
                            {{ $data['institutiontype']['name'] }}
                        </div>
                    </div>  
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Статус </label>
                        <div class="col-md-12"> 
                            @if($data['status'] == 1) 
                                Государвственное
                            @elseif($data['status'] == 2)
                                Негосударвственное
                            @endif 
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Полное название 

                        </label>
                        <div class="col-md-12">
                            {{ $data['full_name'] }} 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Краткое название 

                        </label>
                        <div class="col-md-12">
                            {{ $data['short_name'] }}  
                        </div>
                    </div>
                </div>
                
                @if(!empty($data['other_names']))
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Другие названия

                        </label>
                        <div class="col-md-12">
                            {{ $data['other_names'] }}  
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="panel panel-default">
              <!--   <div class="panel-heading">
                    <h3 class="panel-title">ОБРАЗОВАНИЕ</h3>
                </div> -->
                <div class="panel-body">
                    <div class="row"> 
                        @if($data['secondary_inst'] == '1') 
                            <div class="col-md-12">
                                <p>
                                    Это учебное заведение является факультетом, филиалом, отделением или иной аффилированной структурой в составе другого учебного заведения
                                </p>
                            </div>

                            <div class="parent_institution">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Родительское ВУЗ </label>
                                        <div class="col-md-12"> 
                                            {{ $data['parentInstitution']['name'] }}   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Форма отношения </label>
                                        <div class="col-md-12">
                                            {{ $data['formAttitude']['name'] }}   
                                        </div>
                                    </div>
                                </div>          
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Год основания </label>
                        <div class="col-md-12">
                            {{ $data['year_of_foundation'] }}  
                            <hr> 
                            <ul style="list-style: none; padding: 0;">
                                <li>
                                    <div class="icon_img" style="width: 15px; display: inline-block;"> 
                                        @if($data['has_hostel'] == 1)
                                            <img src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/sign-check-icon.png" style="max-width: 15px;" alt="">
                                            @else
                                            <img src="http://its.umich.edu/sites/all/themes/bootstrap_its/images/device-connection-icon-x.png" style="max-width: 11px;" alt=""> 
                                        @endif 
                                    </div>
                                    Предоставляется общежитие
                                </li>
                                <li>
                                    <div class="icon_img" style="width: 15px; display: inline-block;">
                                        @if($data['has_military_department'] == 1)
                                            <img src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/sign-check-icon.png" style="max-width: 15px;" alt="">
                                            @else
                                            <img src="http://its.umich.edu/sites/all/themes/bootstrap_its/images/device-connection-icon-x.png" style="max-width: 11px;" alt="">
                                        @endif 
                                    </div>
                                    Военная кафедра
                                </li>
                            </ul> 
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="white-space: nowrap;">Лицензия № </label>
                        <div class="col-md-8">
                            {{ $data['license_nr'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-md-3 control-label" style="white-space: nowrap;">От </label>
                        <div class="col-md-9">
                            {{ date('d-m-Y', strtotime($data['license_nr_from'])) }} 
                        </div>
                    </div> 
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="white-space: nowrap;">Аккредитация № </label>
                        <div class="col-md-8">
                            {{ $data['accreditation_nr'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-md-3 control-label" style="white-space: nowrap;">От </label>
                        <div class="col-md-9">
                            {{ date('d-m-Y', strtotime($data['accreditation_nr_from'])) }}
                        </div>
                    </div> 
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Краткое описание</label>
                        <div class="col-md-12">
                            {{ $data['description'] }}
                        </div>
                    </div> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label class="col-md-12 control-label">Типы программ </label>
                        <div class="col-md-12">  
                            {{ $data['programType']['name'] }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Номер телефона 

                        </label>
                        <div class="col-md-12"> 
                            {{ $user['phone'] }}
                        </div>
                    </div>
                        
                    @if(!empty($user['phone2']))
                    <div class="form-group">
                        <label class="col-md-12 control-label">Номер телефона 2
                        </label>
                        <div class="col-md-12">
                            {{ $user['phone2'] }} 
                        </div>
                    </div>
                    @endif
                    
                    @if(!empty($user['cityData']['name']))
                    <div class="form-group">
                        <label class="col-md-12 control-label">Город</label>
                        <div class="col-md-12"> 
                            {{ $user['cityData']['name'] }} 
                        </div>
                    </div>
                    @endif
 
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="ed_institution"
                               class="col-md-12 control-label">Основные рубрики 
                        </label>
                        <div class="col-md-12"> 
                            {{ $data['teachActivity']['name'] }} 
                        </div>
                    </div>
                    
                    @if(!empty($user['site']))
                    <div class="form-group">
                        <label class="col-md-12 control-label">Факс  </label>
                        <div class="col-md-12"> 
                            {{ $user['fax'] }} 
                        </div>
                    </div>
                    @endif
                    
                    @if(!empty($user['site']))
                    <div class="form-group">
                        <label class="col-md-12 control-label">Сайт  </label>
                        <div class="col-md-12"> 
                            {{ $user['site'] }} 
                        </div>
                    </div>
                    @endif
 
                </div>
            </div>

            <a href="/educational-institutions/" class="btn btn-sm btn-default">Вернуться в каталог</a>
            
        </div>
    </div>
</div>
@stop