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
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){
    console.log('lang - ', this.$i18n);
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
