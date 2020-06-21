<template>
  <div>    
    <!--
    <quiz :ifCatalog="true" />-->
    <div class="test-wrapper" :style="{ background: 'url(' + imgSrc + '/storage/images/tests/' + bgImg + ')'}">
      <div class="container">
        
        <quiz/>
        <!--<advertising />-->
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Quiz from '~/components/quiz/Quiz'
//import Advertising from '~/components/advertising/Advertising'


export default {
  layout: 'light',

  components: {
    Quiz,
    //Advertising
  },

  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName ,  
    imgSrc: process.env.appRoot ,  
    bgImg: '', //this.$route.params.img,    
    testInfo: {}
  }),  

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){        
    this.bgImg = this.$route.params.img;
    console.log('params', this.bgImg);
    this.testInfo = {
        id: this.$route.params.id,
        category: 'films'
    }
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
