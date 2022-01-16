@extends('layouts.app')

@section('content') 
    <h1>{{config('app.name')}}</h1>
    <h3>Stav</h3>
    <div style="margin: 10px">
        <ul style="margin: 10px">
            <b>TODO</b>
            <li>Users</li>
            <li>Accoutant IFC</li>
            <li>Mobile app</li>                
        </ul>
        <ul style="margin: 10px">
            <b>In progress</b>
            <li>
                <a href='/tags'>Tags</a>
                <ul>
                    <li><input type="checkbox" checked/> Model </li>
                    <li><input type="checkbox" checked/> List </li>
                    <li><input type="checkbox" checked/> Crud </li>
                    <li><input type="checkbox" checked/> Sorting </li>                                        
                    <li><input type="checkbox"/> Search </li>                    
                </ul>
            </li>  
            <li>
                <a href='/document'>Docs</a>
                <ul>
                    <li><input type="checkbox" checked/> Model </li>
                    <li><input type="checkbox" checked/> List </li>
                    <li><input type="checkbox"/> Crud </li>
                    <li><input type="checkbox"/> OCR </li>  
                    <li><input type="checkbox"/> Sorting, labeing, filtering </li>                    
                </ul>
            </li>    
        </ul>
        <ul style="margin: 10px">
            <b>Finished!</b>
            <li><a href='/role'>Správa rolí</a></li>      
        </ul>
    </div>
@endsection
