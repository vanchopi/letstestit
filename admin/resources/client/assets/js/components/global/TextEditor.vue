<template>
  <div class="app">
    <ckeditor v-model="content" :config="config" @input="onEditorInput" ></ckeditor>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Ckeditor from 'vue-ckeditor2'

export default {
  name: 'TextEditor',
  props: ['textCallbak', 'num', 'cContent'],  
  components: { 
    Ckeditor 
  },
  data () {
    return {
      content: '',
      edit : false,
      config: {
        toolbar: [
            [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'Custom Button', 'Link', 'Unlink', 'Anchor', 'TextColor', 'BGColor', 'Undo', 'Redo', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', ],
        ],
        height: 300,
        /*customConfig: '/ckeditor/custom_config.js',
        extraPlugins: 'custom_plugin'*/
      }
    }
  },
  computed: {
      //...mapGetters('EditorSingle', ['item']),
  },
  created(){
    //this.content = this.contentValue;
    console.log('! attr ',  this.$attrs);
    this.content = this.cContent != undefined ? this.cContent : '';
    this.edit = this.content != '' ? true : false;
  },
  watch: {
    /*'item': function(){
        console.log(this.num ,' model - ', this.item);        
    },*/
    '$attr.value': function(){
        console.log('value - ', this.$attr.value);
    }
  },
  methods:{
      //...mapActions('EditorSingle', ['setItem']),
      onEditorInput(){
          console.log('data - ', this.edit);
          this.textCallbak(this.content, this.num);            
          /*if(!this.edit){
            this.textCallbak(this.content, this.num);            
          }else{
            this.edit = false;
          }*/
      }
  }
}
</script>