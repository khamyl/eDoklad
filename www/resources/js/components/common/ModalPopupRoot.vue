<template>
    <modal-popup :title="title" @close-modal="handleClose" @submit-popup-form="submitForm()">
        <component :is="modal_content" ref="modalContent" v-bind="props" />
    </modal-popup>
</template>

<script>
import { shallowRef } from '@vue/reactivity';
import ModalPopup from './ModalPopup'
export default {
    data () {
        return {                                               
            modal_content: null,
            title: '',            
            //form_id: '',
            props: null
        }
    },

    created () {
        this.eventBus.on('show-modal', ({ modal_content, title = ''/*, form_id = ''*/, obj_id = 0, props = null }) => {                 
            this.modal_content = shallowRef(modal_content),                        
            this.title = title
            //this.form_id = form_id,
            this.props = {obj_id: obj_id}
        });
        document.addEventListener('keyup', this.handleKeyup);
    },

    updated () {
        // if(this.$refs.modalContent != null)
        // this.$refs.modalContent.form.initWithFormID(this.form_id);
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
        },

        submitForm(){            
            //var theForm = this.$refs.modalContent.$refs.theForm;
            // var theMethod = theForm.method;              
            // if(theForm._method !== undefined){
            //     theMethod = theForm._method.value;                              
            // }
            var theForm = this.$refs.modalContent.form;
            theForm.submit()            
                .then(function(data){
                    console.log('Popup form submition OK...:)', data);
                    if(theForm.redirect != ''){
                        this.handleClose();
                        window.location.href = theForm.redirect;
                    }
                }.bind(this))
                .catch(errors => {
                    console.log('Popup form submition error...:(', errors);
                });
        }
    },
    components: { ModalPopup }
}    
</script>
