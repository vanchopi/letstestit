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
  props: {
    textCallbak: {
      type: Function,
      default: () => {},
      required: true,
    },
    num: {
      type: String,
      default: "",
      required: false,
    },
    cContent:{
      type: String,
      default: "",
      required: false,
    },
    windowHeight: {
      type: Number,
      default: 300,
      required: false,
    }
  },  
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
        height: this.windowHeight,
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
    this.content = this.cContent != undefined ? this.cContent : '';
    this.edit = this.content != '' ? true : false;
  },
  watch: {
    /*'item': function(){
        console.log(this.num ,' model - ', this.item);        
    },*/
  },
  methods:{
      //...mapActions('EditorSingle', ['setItem']),
      onEditorInput(){
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