<template>
  <div v-if="ploader == true" class="ploader">
    <div class="dot" id="dot1"></div>
    <div class="dot" id="dot2"></div>
    <div class="dot" id="dot3"></div>
  </div>
</template>

<script>
export default {
  name: 'TextLoader',

  props: ['loader'],
  data: () => ({    
    ploader: true,
  }),
  created(){
      //console.log('pre loader - ', this.loader);
      this.ploader = this.loader;
  },
  watch:{
      'loader'(){
        //console.log('loader - ', this.loader);
        this.ploader = this.loader;
      }
  },
}
</script>

<style scoped lang="scss">
  .ploader{
      position: absolute;
      top: 0;
      left: 46%;
      width: 8%;
      height: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: auto;
  }  
</style>
