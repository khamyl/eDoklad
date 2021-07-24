<div>
    <h1>{{$role['slug']}} <span> {{$role['description']}}</span></h1>
    <div class="clearfix"></div>
</div>

<div class="innerLR">             
    <div class="widget widget-heading-simple widget-body-gray">                
        <div class="widget-body">   
            {{ Form::open(['route' => ['role.update', $role->id], 'method' => 'POST']) }}
            {{ method_field('PUT') }}
            @foreach ($permissions as $permission) 
                <div>
                    {{ Form::checkbox('permissions[]', $permission->id, $checked[$permission->id], ['id' => 'permissions['.$permission->id.']']) }}
                    {{ Form::label('permissions['.$permission->id.']', $permission->slug) }}
                </div>
            @endforeach
            
            {{ Form::close() }}
            
        </div>    
    </div>    
</div>