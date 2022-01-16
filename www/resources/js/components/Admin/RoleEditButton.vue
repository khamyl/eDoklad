<template>
    <button class="btn btn-block btn-default" data-toggle="modal" data-target="#ModalForm" @click="showForm()">
        Edit
    </button>
</template>

<script>
// import Form from '../../forms/Form';
import RoleEditForm from './RoleEditForm';
export default {
    name: "RoleEditButton",
    props: ['roleId'],
    methods:{
        showForm(){
            // var roleID = this.roleId;
            // axios.get('/role/'+roleID+'/edit')
            // .then(response=>{                            
            //     var EditRoleFormComponent = {                         
            //         template: response.data,
            //         data: function(){
            //             return {                               
            //                allPermissions: [],
            //                permissions:[], //role permissions  
            //                form: new Form()                                                                                
            //         }},
            //         mounted(){                            
            //             this.loadRolePermissions(roleID);                        
            //         },
            //         methods:{
            //             loadAllPermissions: function(){                            
            //                 axios.get('/api/permissions')
            //                     .then((response) => {
            //                         this.permissions = response.data.data;
            //                     })
            //                     .catch(function(error){
            //                         console.log(error);
            //                     });
            //             },

            //             loadRolePermissions: function(roleID){                                                     
            //                 axios.get('/api/permissions/'+roleID)
            //                     .then((response) => {                                     
            //                         this.permissions = response.data.data;
            //                         console.log("Loaded permissions: ", this.permissions);  
            //                     })
            //                     .catch(function(error){
            //                         console.log(error);
            //                     });
            //             }
            //         }
            //     };                
            //     this.eventBus.emit('show-modal', {modal_content: EditRoleFormComponent, title: 'Edit role', form_id: 'role_edit_form'});
            // }) 

            this.eventBus.emit('show-modal', {modal_content: RoleEditForm, obj_id: this.roleId, title: 'Edit role'});
        }  
    }
}
</script>
