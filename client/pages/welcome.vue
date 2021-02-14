<template>
  <div>    
    
    <slider :ifCatalog="false" />
        
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Slider from '~/components/slider/Slider'

export default {
  layout: 'default',

  components: {
    Slider
  },

  head () {
    return { 
      title: 'Пройти тесты онлайн: тесты по фильмам, психологические тесты, футбольные тесты, весёлые тесты.',
      //h1: 'Популярные онлайн тесты с любого устройства бесплатно',
      meta: [        
        {
          hid: 'description',
          name: 'description', 
          content:  'Все самые крутые и интересные онлайн тесты на сайте letstestit.ru. Специально подобранные тесты раскроют ваш характер и потренируют Ваше мышление.'
        },
        { 
          hid: 'keywords', 
          name: 'keywords' , 
          content: 'Подборка самых популярных Онлайн Тестов, бесплатные тесты, онлайн тесты'
        },
      ] 
    }
  },

  data: () => ({
    title: process.env.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){
    /*console.log('lang - ', this.$i18n);*/
  },

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
