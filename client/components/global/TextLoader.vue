<template>
  <div  class="ploader-wrapper"
       :class="{'show': ploader}"
    >
    <div class="ploader">
      <div class="dot" id="dot1"></div>
      <div class="dot" id="dot2"></div>
      <div class="dot" id="dot3"></div>
    </div>
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
      this.ploader = this.loader;
  },
  watch:{
      'loader'(){
        this.ploader = this.loader;
      }
  },
}
</script>

<style scoped lang="scss">
  @import '~assets/sass/_variables.scss';
  .ploader-wrapper{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    background-color: $body-bg;
    opacity: 0;
    visibility: hidden;
    transition: visibility .3s ease,
                opacity .3s ease;     
    &.show{
      visibility: visible;
      opacity: 1;
    }
  }
  .ploader{
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;      
      width: 80px;
      height: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: auto;
  }  
</style>
