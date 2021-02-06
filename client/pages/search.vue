<template>
  <div class="catalog-slider__wrapper">    
    <breadcrumbs />    
    <search-result :search="searchStr"/>        
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import SearchResult from '~/components/search/SearchResult'
import Breadcrumbs from '~/components/Breadcrumbs'

export default {
  layout: 'light',

  components: {   
    Breadcrumbs, 
    SearchResult
  },

  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName,
    searchStr: '',
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){
    this.searchStr = this.$route.params.search;
    //console.log(' serach result - ', this.searchStr);
  }
}
</script>

<style scoped lang="scss">

</style>
