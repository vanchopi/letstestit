<template>
  <share-network
      :network="network"
      :url="url"
      :title="dsc"
      :description="values.description"
      :quote="dsc"
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
    dsc: '',
    url: '',
  }),
  created(){    
    this.combineData();
  },
  watch:{
      'values'(){
          //this.combineDsc();
      }
  },
  methods:{
      combineData(){
          let url = window.location.href.indexOf('http://localhost:3000') > 0 ? window.location.href : 'http://letstestit.ru' + window.location.href.split('http://localhost:3000')[1];
          if (this.values.correct !== null){
              this.dsc = 'Результат - ' + this.values.correct + ' ' + 'из'/*this.$t('from')*/ + ' ' + this.values.questions + ' - ' + this.values.title + ', в тесте: ' + this.values.name;
          }else{
              this.dsc = 'Результат - ' + this.values.title + ', в тесте: ' + this.values.name;
          }
          console.log('href - ', url);
          this.url = url;
          return this.dsc;
      }
  }
}
</script>

<style scoped lang="scss">           
</style>
