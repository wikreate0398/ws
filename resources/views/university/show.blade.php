@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">
        <div class="col-md-12 form-horizontal">
            <h1>{{ $data['full_name'] }}</h1>
 
               
            <div class="row"> 
                 
               
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Краткое описание 

                        </label>
                        <div class="col-md-12">
                            {{ $data['user']['about'] }}  
                        </div>
                    </div>
                </div> 
            </div>

            
            <a href="/educational-institutions/" class="btn btn-sm btn-default">Вернуться в каталог</a>
            
        </div>
    </div>
</div>
@stop