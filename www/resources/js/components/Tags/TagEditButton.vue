<template>
    <a class="btn btn-action icon-pencil btn-primary" style="color: rgba(255,255,255, 0.7)" data-toggle="modal" data-target="#ModalForm" @click="showForm()"></a>
</template>

<script>
import TagEditForm from './TagEditForm';
export default {
    name: "TagEditButton",
    props: ['tagId'],
    methods:{
        showForm(){            
            this.eventBus.emit('show-modal', {modal_content: TagEditForm, obj_id: this.tagId, title: 'Edit tag'});
        }  
    }
}
</script>
