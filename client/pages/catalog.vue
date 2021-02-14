<template>
  <div class="catalog-slider__wrapper">    
    <breadcrumbs />
    <categories-slider />
        
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CategoriesSlider from '~/components/slider/CategoriesSlider'
import Breadcrumbs from '~/components/Breadcrumbs'

export default {
  layout: 'light',

  components: {   
    Breadcrumbs, 
    CategoriesSlider
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
          content: 'тесты, тесты онлайн, онлайн тесты, популярные тесты, новые тесты'
        },
      ] 
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
