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
    return { title: this.$t('home') }
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
