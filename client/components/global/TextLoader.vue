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
  watch:{
      'loader'(){
        console.log('loader from slider component - ',this.loader);
      }
  },
}
</script>

<style scoped lang="scss">
  .ploader{
      position: absolute;
      width: 100%;
      height: 100%;
      justify-content: center;
      align-items: center;
  }  
</style>
