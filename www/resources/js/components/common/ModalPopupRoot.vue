<template>
    <modal-popup :title="title" @close-modal="handleClose">
        <component :is="modal_content" v-bind="props" />
    </modal-popup>
</template>

<script>
import ModalPopup from './ModalPopup'
export default {
    data () {
        return {
            modal_content: null,
            title: '',
            props: null
        }
    },

    created () {
        this.$eventBus.$on('show-modal', ({ modal_content, title = '', props = null }) => {                 
            this.modal_content = modal_content,
            this.title = title,
            this.props = props
        })
        document.addEventListener('keyup', this.handleKeyup)
    },

    beforeDestroy () {
        document.removeEventListener('keyup', this.handleKeyup)
    },

    methods: {
        handleClose () {
            console.log("Handling close...");
            this.modal_content = null;
            this.title='';
            $("#ModalForm").click();
        },
        handleKeyup (e) {
            if (e.keyCode === 27 && this.modal_content != null) this.handleClose()
        }
    },
    components: { ModalPopup }
}    
</script>
