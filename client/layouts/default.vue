<template>
  <div class="layout">
  <navbar />
	<breadcrumbs />
	<banner />

  <nuxt />

  <main-footer />
    
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Breadcrumbs from '~/components/Breadcrumbs'
import Banner from '~/components/Banner'
import MainFooter from '~/components/MainFooter'

export default {
  name: 'Default',
  components: {
    Navbar,
    Breadcrumbs,
    Banner,
    MainFooter    
  }
}
</script>
