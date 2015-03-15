@extends('layout.index')

@section('content')
<div class="col-md-12 main middleWrap">
    <div class="row">
        <div class="row">
            <h1>{{$movie->name}}</h1>
        </div>
        <div class="row">
            <p>{{$movie->review}}</p>
        </div>
        <div class="row">
            <div class="col-md-2"><a href="{{url('/word/'.$movie->id)}}" class="btn btn-large btn-primary">Word Analysis</a></div>
            <div class="col-md-2"><a href="{{url('/sentiment/'.$movie->id)}}" class="btn btn-large btn-primary">Sentiment Analysis</a></div>
        </div>
    </div>
    @stop