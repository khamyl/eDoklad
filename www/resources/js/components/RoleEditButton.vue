<template>
    <button class="btn btn-block btn-default" data-toggle="modal" data-target="#ModalForm" @click="showForm()">
        Edit
    </button>
</template>

<script>
import Form from '../forms/Form';
export default {
    name: "role-edit-button",
    props: ['roleId'],
    methods:{
        showForm(){
            axios.get('/role/'+this.roleId+'/edit')
            .then(response=>{              
                var EditRoleForm = {                         
                    template: response.data,
                    data: function(){
                        return {
                            form: new Form()
                    }}
                };                
                this.eventBus.emit('show-modal', {modal_content: EditRoleForm, title: 'Edit role'});
            }) 
        }  
    }
}
</script>
