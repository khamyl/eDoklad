<template>
  <form
    accept-charset="UTF-8"
  >
    <div class="container">

      <div class="row valign-center" style="margin-bottom: 1em">
        <div class="col-md-2 pr-0">
          <span class="badge" :style="'background-color: ' + form.color +'; color: ' + fgColor" v-text="form.tag"></span>
        </div>
      </div>  

      <div class="row valign-center">
        <div class="col-md-6 pr-0">
          <div class="form-group" :class="{ 'has-error': form.errors.has('tag') }">
            <label for="Tag:" class="control-label">Tag:</label>
            <span
              style="margin: 0px"
              class="btn-action single glyphicons circle_question_mark"
              data-toggle="tooltip"
              data-placement="right"
              data-original-title="Tag is mandatory."
              ><i></i></span>
            <input class="form-control" name="tag" type="text" maxlength="30" v-model="form.tag" />
            <p class="help-block" v-if="form.errors.has('tag')" v-text="form.errors.get('tag')"></p>
          </div>
        </div>        
        <div class="col-md-3 pr-0">
          <div class="form-group" :class="{ 'has-error': form.errors.has('color') }">            
            <label for="color" class="control-label">Color:</label>
            <span
              style="margin: 0px"
              class="btn-action single glyphicons circle_question_mark"
              data-toggle="tooltip"
              data-placement="right"
              data-original-title="Format: #RRGGBB"
              ><i></i></span>
            <input class="form-control" name="color" type="text" maxlength="7" v-model="form.color" v-on:keyup="sanitizeColorFormat" />
            <p class="help-block" v-if="form.errors.has('color')" v-text="form.errors.get('color')"></p>
          </div>
        </div>          
        <div class="col-md-3 pr-0">
          <span class="btn btn-block btn-default btn-icon glyphicons refresh pr-0 pl-0" style="width: 34px; height:34px; margin-top:10px" @click="randomizeColor()"><i></i></span>          
        </div>        
      </div><!--row-->  
      <div>
        <div class="form-group" :class="{ 'has-error': form.errors.has('description') }">
          <label for="description" class="control-label">Description:</label> 
          <input class="form-control" name="description" type="text" maxlength="255" v-model="form.description" />
          <p class="help-block" v-if="form.errors.has('description')" v-text="form.errors.get('description')"></p>
        </div>  
      </div>  
    </div>
  </form>
</template>

<script>
import Form from '../../forms/Form';
export default {
    name: "TagEditForm",
    props: ['obj_id'],
    data: function(){        
        var do_edit = this.obj_id !== undefined && this.obj_id != '' && this.obj_id > 0;
        return {   
            fgColor: '',                                    
            form: new Form({
                //Header
                action: (do_edit) ? '/tags/'+this.obj_id : '/tags',
                method: (do_edit) ? 'put'                : 'post',
                redirect: '/tags',
                //Data 
                tag: '',
                color: '', 
                description: '', 
            })                                                                             
    }},

    computed: {
      bgColor() {
        return this.form.color;
      }
    },

    watch: {
      // whenever bg color changes, this function will run
      bgColor: function (newColor, oldColor) {
        //this.fgColor = 'Waiting for you to stop typing...'
        this.debouncedGetFgColor()
      }
    },

    mounted(){     
        Promise.all([this.loadTag(this.obj_id)])
        .then((allResults) => {            
            this.eventBus.emit('data-loaded', {});
        })                                                                  
    },

    created() {
      // _.debounce is a function provided by lodash to limit how
      // often a particularly expensive operation can be run.
      // In this case, we want to limit how often we access
      // api/tags/getFgColor, waiting until the user has completely
      // finished typing before making the ajax request. To learn
      // more about the _.debounce function (and its cousin
      // _.throttle), visit: https://lodash.com/docs#debounce
      this.debouncedGetFgColor = _.debounce(this.getFgColor, 300);
    },

    methods:{
        loadTag: function(tagID){     
            console.log('Loading tag #'+tagID);
          
            //If we don't have tag - we create a new tag - do not load the tag      
            if(tagID === undefined || tagID == '' || tagID < 1)
                return Promise.resolve();

            return axios.get('/api/tags/'+tagID)
                .then((response) => {                                     
                    var the_tag = response.data.data;
                    this.form.tag = the_tag.tag;
                    this.form.description = the_tag.description;
                    this.form.color = the_tag.color;                
                })
                .catch(function(error){
                    console.log(error);
                });
        },

        getFgColor: function () {
          if (this.bgColor.indexOf('#') !== 0) {
            //console.log('Color should start with a hash tag ;) "' + this.bgColor +'"');
            return;
          }
          //console.log('Computing the FG Color...');
          var vm = this
          axios.get('api/tags/getFgColor/'+encodeURIComponent(this.form.color))
            .then(function (response) {
              vm.fgColor = _.capitalize(response.data)
            })
            .catch(function (error) {
              console.log('Error! Could not reach the API. ' + error);
            })
        },

        getRandomColor: function(){
          return Math.floor(Math.random()*16777215).toString(16);
        },

        randomizeColor:function(){
          this.form.color = "#" + this.getRandomColor();
        },

        sanitizeColorFormat: function(e){
          var sanitized = e.currentTarget.value.replace(/[^0-9a-f]/g,'');
          e.currentTarget.value = '#'+sanitized;
        }
    }
}
</script>
