<template>
    <div class="buttons pull-right" data-toggle="modal" data-target="#ModalForm" @click="showForm()">    	
        <a href="#" class="btn btn-primary btn-icon glyphicons circle_plus"><i></i>Add Role</a>
    </div>    
</template>

<script>
//import Form from '../../forms/Form';
import RoleEditForm from './RoleEditForm';
export default {
    methods:{
        showForm(){
            // axios.get('/role/create').then(response=>{                
            //     var RoleFormComponent = { 
            //         template: response.data,
            //         data: function(){
            //             return {                                                  
            //                 formData: {
            //                     slug: '',
            //                     desc: '',
            //                     perms: []
            //                 },
            //                 form: new Form()   
            //         }},
            //         mounted(){                                    
            //             this.form.initWithData(this.formData);  
            //         }
            //     };                                
            //     this.eventBus.emit('show-modal', {modal_content: RoleFormComponent, title: 'Create role'});
            // })
            
            this.eventBus.emit('show-modal', {modal_content: RoleEditForm, title: 'Create role'});
        }   
    }
}
</script>