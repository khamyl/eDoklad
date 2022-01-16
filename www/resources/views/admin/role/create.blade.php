{{-- Implemented as Vue component --}}

{{-- {{ Form::open(['route' => 'role.store', 'method' => 'POST', '@submit.prevent'=>'onSubmit', '@keydown'=>'errors.clear($event.target.name)', 'ref'=>'theForm']) }}

<div class='container'>
    <div class="form-group" :class="{ 'has-error':form.errors.has('slug') }" style="width:50%">
        {{Form::label('Slug:', null, ['class'=>'control-label'])}}
        <span style="margin: 0;" class="btn-action single glyphicons circle_question_mark" data-toggle="tooltip" data-placement="top" data-original-title="Slug is mandatory and cannot contain whitespace."><i></i></span>  
        {{Form::text( 'slug',    '', ['class'=>'form-control', 'v-model' => 'formData.slug'])}}      
        {{Form::fieldErr('slug')}}    
    </div>
    <div>
        {{Form::label('Description:', null, ['class'=>'control-label'])}}
        {{Form::text( 'description',    '', ['class'=>'form-control', 'v-model' => 'formData.desc'])}}    
    </div>
</div>

<div class='separator line bottom'></div>

<div class="innerLR">             
    <div class="widget widget-heading-simple widget-body-gray">                
        <div class="widget-body">   
            
            @foreach ($permissions as $permission) 
                <div>
                    {{ Form::checkbox('permissions[]', $permission->id, false, ['id' => 'permissions['.$permission->id.']', 'v-model' => 'formData.permissions']) }}
                    {{ Form::label('permissions['.$permission->id.']', $permission->slug) }}
                </div>
            @endforeach            
        </div>    
    </div>    
</div>

{{ Form::close() }} --}}