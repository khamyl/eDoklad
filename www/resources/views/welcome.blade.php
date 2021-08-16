@extends('layouts.app')

@section('content') 
    <h1>{{config('app.name')}}</h1>
    <h3>Stav</h3>
    <div style="margin: 10px">
        <ul style="margin: 10px">
            <b>In progress</b>
            <li><a href='/role'>Správa rolí</a></li>    
        </ul>
        <ul style="margin: 10px">
            <b>Finished!</b>
            <li><i>NaN</i></li>    
        </ul>
    </div>
@endsection
