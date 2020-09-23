<template>
  <share-network
      :network="network"
      :url="values.url"
      :title="values.title"
      :description="values.description"
      :quote="values.quote"
      :hashtags="values.hashtags"
      :media="values.media"
      class="social-item"
    >
  </share-network>
</template>

<script>

import { ShareNetwork } from '@/../node_modules/vue-social-sharing/dist/vue-social-sharing'

export default {
  name: 'Share',

  components: {
      ShareNetwork,
  },

  props: ['values', 'network'],
  data: () => ({    
    //ploader: true,
  }),
  created(){    
    console.log('values',this.values);    
  },
  watch:{
      /*'loader'(){
        console.log('loader from slider component - ',this.loader);
        this.ploader = this.loader;
      }*/
  },
}
</script>

<style scoped lang="scss">           
</style>
