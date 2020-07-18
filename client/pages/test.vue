<template>
  <div>    
    <!--
    <quiz :ifCatalog="true" />-->
    <div class="test-wrapper" :style="{ background: 'url(' + imgSrc + '/storage/images/tests/' + bgImg + ')'}">
      <div class="container">
        
        <quiz :test="testList"/>
        <!--<advertising />-->
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Quiz from '~/components/quiz/Quiz'
import { getTest } from '~/api/test/test'
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
    bgImg: '1.png', //this.$route.params.img,  
    testList: null,  
    testInfo: {}
  }),  

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){            
    console.log('params', this.bgImg);    
    this.testInfo = {
        id: this.$route.params.id,
        category: 'films'
    };
    this.getThisTest(this.testInfo.id);
  },
  methods:{
    getThisTest(id){
      getTest(id).then((request) => {
        this.testList = request.data.questions;
        this.bgImg = request.data.main_image;
        console.log('123', this.bgImg);
        console.log( 'test - ', this.testList );
      })
    }
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
