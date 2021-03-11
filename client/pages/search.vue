<template>
  <div class="catalog-slider__wrapper">    
    <breadcrumbs />    
    <search-result :search="searchStr"/>        
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import SearchResult from '~/components/search/SearchResult'
import Breadcrumbs from '~/components/Breadcrumbs'

export default {
  layout: 'light',

  components: {   
    Breadcrumbs, 
    SearchResult
  },

  head () {
    return { 
      title: 'Онлайн тесты c точным результатом от психологических до iq',
      //h1: 'Онлайн тесты',
      meta: [        
        {
          hid: 'description',
          name: 'description', 
          content:  'Тесты онлайн на различные темы собраны в одном месте для вашего удобства. Наслаждайтесь и познавайте себя!'
        },
        { 
          hid: 'keywords', 
          name: 'keywords' , 
          content: 'тесты, тесты онлайн, онлайн тесты, популярные тесты, новые тесты, найти тесты'
        },
      ] 
    }
  },

  data: () => ({
    title: process.env.appName,
    searchStr: '',
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  watch:{ 
    '$route.query'(){
      this.searchStr = this.$route.query.q;
      this.$store.dispatch("search/fetchSearchResult", { str:this.searchStr } );
      //console.log('router serach result - ', this.searchStr);  
    }
  },

  created(){
    this.searchStr = this.$route.query.q;
    this.$store.dispatch("search/fetchSearchResult", { str:this.searchStr });
    //console.log(' serach result - ', this.searchStr);
  }
}
</script>

<style scoped lang="scss">

</style>
