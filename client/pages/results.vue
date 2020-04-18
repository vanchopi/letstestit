<template>
  <div>    
    
    <results />

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Results from '~/components/results/Results'

export default {
  layout: 'light',

  components: {    
    //Advertising
    Results
  },

  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName,        
    testInfo: {}
  }),  

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){    
    /*this.testInfo = {
        id: this.$route.params.id,
        category: 'films'
    }*/
  },
  methods:{
    
    
  }
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
