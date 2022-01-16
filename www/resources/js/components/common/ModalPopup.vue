<template>    
    <!-- Originnaly its a bootsrap popup! -->
    <div id="ModalForm" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @click="$emit('close-modal')">
        <div class="modal-dialog" @click.stop>
            <div class="modal-content">  
                <div class="overlay" v-if="!this.isContentLoaded">                
                    <div class="overlay__inner">
                        <div class="overlay__content">
                            <div class="loading-spinner" style="margin-top:10px" >
                                <div class="loader" id="loader-1"></div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  @click="$emit('close-modal')">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">{{ (title!='')?title:'Loading...' }}</h4>
                </div>
                      
                <div id='modal_body' class="modal-body" >                     
                    <slot />
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="$emit('close-modal')">Close</button>
                    <button type="button" class="btn btn-primary btn-submit" @click="$emit('submit-popup-form')">Save changes</button>
                </div>
            </div>  
        </div>
    </div>
</template>

<style>
.overlay {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
    background: rgba(50,50,50,0.5);
    z-index: 9999;
}

.overlay__inner {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}

.overlay__content {
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>

<script>    
    import {Comment} from 'vue';
    export default {        
        props: {
            title: String
        },

        data: function(){
            return {
                isContentLoaded: false
            }
        },

        created () {
            this.eventBus.on('data-loaded', ({}) => {               
                this.isContentLoaded = true;
            });
            this.eventBus.on('show-modal', ({}) => {           
                this.isContentLoaded = false;
            });
        },

        methods: {
            isSlotEmpty(){//Used when anonymous dynamic component is loaded from server as popup content (defined on buttons - now commented out)
                return this.$slots.default()[0].type == Comment;
            }
        },        
    }
    
</script>