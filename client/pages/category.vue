<template>
  <div class="catalog-slider__wrapper">    
    <breadcrumbs />
    <span :data-meta="meta.title"></span>
    <tests-list :ifCatalog="false" />
        
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import TestsList from '~/components/testsList/testsList'
import Breadcrumbs from '~/components/Breadcrumbs'
import { getMeta } from '~/api/categories/category'

export default {
  layout: 'light',

  components: {  
    Breadcrumbs,   
    TestsList
  },
  async asyncData({route, params}){
    //console.log('params - ', route.params);
    try{
      const  list  =  await getMeta(route.params.url);                               
      const meta = list.data;
      console.log('meta - ',  meta);
      return {meta};
    }catch(e){
      console.log(e);
    }
  },
  head () {
    return { 
      title: this.$t('home'),
      meta: [{
        name: 'keywords',
        content: this.meta.keywords,
      }] 
    }
  },

  data: () => ({
    title: process.env.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.laravel {
  color: #2e495e;
}

.nuxt {
  color: #00c48d;
}
</style>
