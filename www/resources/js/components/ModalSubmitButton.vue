<template>
    <button type="button" class="btn btn-primary btn-submit" @click="submitModalForm">Save changes</button>    
</template>

<script>
    import Form from '../forms/Form';
    export default {
        mounted() {
            //console.log('ModalSubmitButton Component mounted.')
        },

        props: [],

        data: function() {
            return {
                form: new Form({
                    slug: ''
                })
            }
        },

        methods:{
            submitModalForm(event){
                
                //$(event.target).closest('#ModalForm')
                var the_forms = $('#ModalForm form');
                var the_form;
                var form_data;
                if(the_forms.length == 1){
                    the_form = the_forms[0];
                    $(the_form).find('.is-ajax-field').remove();
                    $(the_form).append('<input class="is-ajax-field" type="hidden" name="ajax" value="1" />');
                    form_data = new FormData(the_form);
                }else{
                    throw new Error('Error: The #ModalForm must contain exactly one form!');                
                }
                            
                this.form.post($(the_form).attr('action'))
                    .then(data=>{
                        console.log('Post ok...');
                    })
                    .catch(errors=>{
                        console.log('Post error...');
                    });    
            }
        }
    }
</script>