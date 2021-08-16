<template>
    <!-- Originnaly its a bootsrap popup! -->
    <div id="ModalForm" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @click="$emit('close-modal')">
        <div class="modal-dialog" @click.stop>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  @click="$emit('close-modal')">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">{{ (title!='')?title:'Loading...' }}</h4>
                </div>
                <div class="loading-spinner" style="margin-top:10px" v-if="this.isSlotEmpty()">
                    <div class="loader" id="loader-1"></div>
                </div>
                <div id='modal_body' class="modal-body" >
                    <slot />
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="$emit('close-modal')">Close</button>
                    <button type="button" class="btn btn-primary btn-submit">Save changes</button>
                </div>
            </div>  
        </div>
    </div>
</template>

<script>    
    import {Comment} from 'vue';
    export default {        
        props: {
            title: String
        },

        methods: {
            isSlotEmpty(){
                return this.$slots.default()[0].type == Comment;
            }
        },        
    }
    
</script>