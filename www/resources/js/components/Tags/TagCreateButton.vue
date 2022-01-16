<template>
    <div class="buttons pull-right" data-toggle="modal" data-target="#ModalForm" @click="showForm()">    	
        <a href="#" class="btn btn-primary btn-icon glyphicons circle_plus"><i></i>Add Tag</a>
    </div>    
</template>

<script type="text/javascript">
import TagEditForm from './TagEditForm';
export default {
    methods:{
        showForm(){          
            this.eventBus.emit('show-modal', {modal_content: TagEditForm, title: 'Create Tag'});
        }   
    }
}
</script>