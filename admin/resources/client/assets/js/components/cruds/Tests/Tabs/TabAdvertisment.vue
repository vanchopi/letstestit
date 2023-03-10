<template>
  <div class="form-group">
    <label for="seo_title">Title</label>
    <input type="text" 
       class="form-control" 
       :placeholder="''"         
       :name="''"
       v-model="result"
    >
  </div>
</template>

<script>
export default {
  name: "TabAdvertisment",
  props: {    
  },
  data(){
    return {
      result: null,
      advertisment: [
        {
          link: null,
          img: null,
        }
      ]
    }
  }
};
</script>
