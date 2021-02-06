<template>
  <div>            
    <div id="test-wrapper" class="test-wrapper">
      <div id="loader" class="faded-bg show"></div>
      
      <div class="container">
        <breadcrumbs />
        <quiz :test="testList" :category="test.category_url" :restartTest="restartTest"/>
        <results />
        <!--<advertising />-->
      </div>
    </div>
    <nuxt-child/>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import Quiz from '~/components/quiz/Quiz'
import Results from '~/components/results/Results'
import Breadcrumbs from '~/components/Breadcrumbs'
import { getTest } from '~/api/test/test'
//import Advertising from '~/components/advertising/Advertising'
import { getMeta } from '~/api/test/test'


export default {

  /*beforeRouteLeave (to, from, next) {
      console.log('beforeRouteLeave');
      this.$store.dispatch("test/clearTestResults");
      next();
  },*/
  layout: 'light',

  components: {
    Quiz,
    Breadcrumbs,
    Results,
    //Advertising
  },

  async asyncData({route, params}){    
    try{
      /*const  list  =  await getMeta(route.params.url);                               
      const meta = list.data;*/
      const list = await getTest(route.query.id);
      const test = list.data;
      console.log('test - ', test);
      //console.log('1. async test - ',  test.questions);
      return {test};
    }catch(e){
      console.log(e);
    }
  },

  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName ,  
    imgSrc: process.env.appRoot ,  
    bgImg: '1.png', 
    testList: null,
    restartTest: false,
  }),  

  computed:{
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      testResults: state => state.test.results,      
    })
  },

  watch:{
      'testResults'(){
          if(this.testResults == null){
              this.bgImg = this.test.main_image;          
              this.restartTest = true;
          }else{
              this.bgImg = this.testResults.img;
              this.restartTest = false;
          }
          this.changeBgImg();
      }
  },

  created(){                    
    this.testList = this.test.questions;
    this.bgImg = this.test.main_image;
  },
  mounted(){
      this.loadImage();
  },
  destroyed() {
      console.log();
      this.$store.dispatch("test/clearTestResults");
  },
  methods:{
    changeBgImg(){
        let wrp = document.getElementById('test-wrapper'),
            loader = document.getElementById('loader');
        wrp.style.cssText = "";
        loader.classList.add("show");
        this.loadImage();
    },
    changeDataSrcToSrc(src) {        
        let img = new Image();
        let wrp = document.getElementById('test-wrapper'),
            loader = document.getElementById('loader');
        img.src = src;
        img.onload = function (){
            wrp.style.cssText = "background: url('" + src + "')";
            loader.classList.remove("show");
        };
    },
    loadImage(){
        let dir = this.testResults == null ? 'tests/' : 'results/',
            src = this.imgSrc + '/storage/images/' + dir + this.bgImg;
        this.changeDataSrcToSrc(src);
    },
  }
}
</script>

<style scoped lang="scss">
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
.test-wrapper{
    position: relative;
    .faded-bg{
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1;
        visibility: hidden;
        opacity: 0;
        background-color: white;
        transition: opacity .3s ease, visibility .3s ease;
        &.show{
            visibility: visible;
            opacity: 1;
        }        
    }
    .container{
        position: relative;
        z-index: 2;
    }
}
</style>
