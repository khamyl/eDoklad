<template>
    <div class="buttons pull-right" data-toggle="modal" data-target="#ModalForm" @click="showForm()">    	
        <a href="#" class="btn btn-primary btn-icon glyphicons circle_plus"><i></i>Add Role</a>
    </div>    
</template>

<script>
import Form from '../forms/Form';
export default {
    methods:{
        showForm(){
            axios.get('/role/create').then(response=>{                
                var CreateRoleForm = { 
                    template: response.data,
                    data: function(){
                        return {
                            form: new Form({"slug": ""}),
                    }}
                };                
                this.$eventBus.$emit('show-modal', {modal_content: CreateRoleForm, title: 'Create role'});
            }) 
        }   
    }
}
</script>