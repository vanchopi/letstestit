<template>
  <div>    
    <!--
    <quiz :ifCatalog="true" />-->
        <div class="test-wrapper" style="background: url(/tests/1.png);">
          <div class="container">
            test
          </div>
        </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import Quiz from '~/components/quiz/Quiz'

export default {
  layout: 'default',

  components: {
    //Quiz
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
