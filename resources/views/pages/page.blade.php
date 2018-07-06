@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">
        <div class="col-lg-12">
            <h1>{{ $page['name'] }}</h1>
            {!! $page['text'] !!}
        </div> 
    </div>
</div>
@stop