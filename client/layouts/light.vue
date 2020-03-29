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

export default {
  components: {
    Navbar,    
    Banner,
    MainFooter    
  }
}
</script>
