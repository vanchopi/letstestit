<template>
  <div class="catalog-slider__wrapper">    
    <breadcrumbs />    
    <about />
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
//import SearchResult from '~/components/search/SearchResult'
import About from '~/components/about/About'
import Breadcrumbs from '~/components/Breadcrumbs'

export default {
  layout: 'light',

  components: {   
    Breadcrumbs, 
    About
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
    
  },

  created(){
    
  }
}
</script>

<style scoped lang="scss">

</style>
