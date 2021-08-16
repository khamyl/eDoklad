@extends('layouts.app')

{{-- @section('addButton')
    <div class="buttons pull-right">    	
        <a href="#" class="btn btn-primary btn-icon glyphicons circle_plus"><i></i> {{__('Add Role')}}</a>
    </div>
@endsection --}}

@section('content')
    <div class="heading-buttons">
        <h1>{{__('Roles')}} <span>{{__('Manage roles\' permissions')}}</span></h1>
        <role-create-button />         
        <div class="clearfix"></div>
    </div>

    <div class="innerLR">             
        <div class="widget widget-heading-simple widget-body-gray">                
            <div class="widget-body">                                    
                <table class='footable table table-striped table-bordered table-white table-primary default footable-loaded'>    
                    <thead>
                        <tr>
                            <th>{{__('Role')}}</th>                
                            <th>{{__('Description')}}</th>                      
                            <th>{{__('Permissions')}}</th>                      
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        @foreach ($roles as $role)            
                        <tr> 
                            <td><b>{{$role['slug']}}</b></td> 
                            <td>{{$role['description']}}</td>   
                            <td>{{$permissions[$role['id']]->pluck('slug')->implode(', ')}}</td>
                        <td>
                            @if ($role['slug'] != 'super_admin')
                                <role-edit-button role-id = "{{ $role->id }}"></role-edit-button>
                            @endif                            
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>                    
            </div>
        </div>               
    </div>

    <modal-popup-root/>

@endsection