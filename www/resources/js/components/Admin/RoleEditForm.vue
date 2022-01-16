<template>
  <form
    accept-charset="UTF-8"
  >
    <div class="container">
      <div class="form-group" :class="{ 'has-error': form.errors.has('slug') }" style="width: 50%">
        <label for="Slug:" class="control-label">Slug:</label>
        <span
          style="margin: 0px"
          class="btn-action single glyphicons circle_question_mark"
          data-toggle="tooltip"
          data-placement="right"
          data-original-title="Slug is mandatory and cannot contain whitespace."
          ><i></i></span>
        <input class="form-control" name="slug" type="text" v-model="form.slug" />
        <p class="help-block" v-if="form.errors.has('slug')" v-text="form.errors.get('slug')"></p>
      </div>
      <div>
        <label for="Description:" class="control-label">Description:</label>
        <input class="form-control" name="description" type="text" v-model="form.description" />
      </div>
    </div>
    <div class="separator line bottom"></div>
    <div class="innerLR">
      <div class="widget widget-heading-simple widget-body-gray">
        <div class="widget-body">
          <div v-for="permission in all_permissions" :key="permission.id">
            <input type="checkbox" :id="'permissions['+permission.id+']'" :value="permission.id" v-model="form.permissions"/>&nbsp;
            <label :for="'permissions['+permission.id+']'">{{permission.slug}}</label>
          </div>          
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import Form from '../../forms/Form';
export default {
    name: "RoleEditForm",
    props: ['obj_id'],
    data: function(){
        var do_edit = this.obj_id !== undefined && this.obj_id != '' && this.obj_id > 0;
        return {                                       
            all_permissions: [],
            form: new Form({
                //Header
                action: (do_edit) ? '/role/'+this.obj_id : '/role',
                method: (do_edit) ? 'put'                : 'post',
                redirect: '/role',
                //Data 
                slug: '',
                description: '', 
                permissions: []
            })                                                                             
    }},
    mounted(){     
        Promise.all([this.loadAllPermissions(), this.loadRole(this.obj_id)])
        .then((allResults) => {            
            this.eventBus.emit('data-loaded', {});
        })                                                                  
    },
    methods:{
        loadAllPermissions: function(){                            
            return axios.get('/api/permissions')
                .then((response) => {
                    this.all_permissions = response.data.data;
                })
                .catch(function(error){
                    console.log(error);
                });
        },

        loadRole: function(roleID){      
            //If we don't have role - we create a new role - do not load the role      
            if(roleID === undefined || roleID == '' || roleID < 1)
                return Promise.resolve();

            return axios.get('/api/permissions/'+roleID)
                .then((response) => {                                     
                    var the_role = response.data.data;
                    this.form.slug = the_role.slug;
                    this.form.description = the_role.description;
                    this.form.permissions = the_role.permissions.map(obj => obj.id);                
                })
                .catch(function(error){
                    console.log(error);
                });
        }
    }
}
</script>
