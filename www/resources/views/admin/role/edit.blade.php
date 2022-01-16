{{-- Implemented as Vue component --}}

{{-- <div>
    <h1>{{$role['slug']}} <span> {{$role['description']}}</span></h1>
    <div class="clearfix"></div>
</div>

<div class="innerLR">             
    <div class="widget widget-heading-simple widget-body-gray">                
        <div class="widget-body">   
            {{ Form::open(['id' => 'role_edit_form', 'route' => ['role.update', $role->id], 'method' => 'POST', 'ref'=>'theForm']) }}
            {{ method_field('put') }}
            @foreach ($permissions as $permission) 
                <div>
                    {{ Form::checkbox('permissions', $permission->id, $checked[$permission->id], ['id' => 'permissions['.$permission->id.']', ':checked'=>'allPermissions.includes("'.$permission->id.'")', 'v-model'=>'form.permissions']) }}
                    {{ Form::label('permissions['.$permission->id.']', $permission->slug) }}
                </div>
            @endforeach
            
            {{ Form::close() }}
            
        </div>    
    </div>    
</div> --}}