<template>
  <div class="layout light">
  <navbar />
		

  <nuxt />

  <main-footer />
    
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Banner from '~/components/Banner'
import MainFooter from '~/components/MainFooter'
import loader from '~/store/loader.js'

export default {
  name: 'Light',
  components: {
    Navbar,    
    Banner,
    MainFooter    
  },
  beforeCreate() {
    console.log('beforeCreate default');
    loader.dispatch("changeLoading", true);
  },
  mounted(){
    setTimeout(function(){
      loader.dispatch("changeLoading", false);
    }, 500);
  }
}
</script>
