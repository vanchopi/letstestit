<template>
  <div class="app">
    <ckeditor v-model="content" :config="config" @input="onEditorInput"></ckeditor>
  </div>
</template>

<script>
import Ckeditor from 'vue-ckeditor2'

export default {
  name: 'TextEditor',
  components: { 
    Ckeditor 
  },
  data () {
    return {
      content: '',
      config: {
        toolbar: [
            [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'Custom Button', 'Link', 'Unlink', 'Anchor', 'TextColor', 'BGColor', 'Undo', 'Redo' ],
        ],
        height: 300,
        /*customConfig: '/ckeditor/custom_config.js',
        extraPlugins: 'custom_plugin'*/
      }
    }
  },
  methods:{
      onEditorInput(){
          console.log('data - ', this.content);
      }
  }
}
</script>