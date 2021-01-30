<template>
  <div>        
    <!--<div id="test-wrapper" class="test-wrapper" :style="{ background: 'url(' + imgSrc + '/storage/images/tests/' + bgImg + ')'}">-->
    <div id="test-wrapper" class="test-wrapper">
      <div id="loader" class="faded-bg show"></div>
      
      <div class="container">
        <breadcrumbs />
        <quiz :test="testList"/>
        <!--<advertising />-->
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Quiz from '~/components/quiz/Quiz'
import Breadcrumbs from '~/components/Breadcrumbs'
import { getTest } from '~/api/test/test'
//import Advertising from '~/components/advertising/Advertising'
import { getMeta } from '~/api/test/test'


export default {
  layout: 'light',

  components: {
    Quiz,
    Breadcrumbs,
    //Advertising
  },

  async asyncData({route, params}){    
    try{
      /*const  list  =  await getMeta(route.params.url);                               
      const meta = list.data;*/
      const list = await getTest(route.params.id);
      const test = list.data;
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
    bgImg: '1.png', //this.$route.params.img,  
    testList: null,  
    testInfo: {},
    //testTest: null,
  }),  

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  watch:{
      /*'testTest'(){
        console.log('test from watch - ', this.testTest);
      }*/
  },

  created(){                
    this.testInfo = {
        id: this.$route.params.id,
        category: 'films'
    };
    //this.getThisTest(this.testInfo.id);
    //this.testTest = this.test;
    this.testList = this.test.questions;
    this.bgImg = this.test.main_image;    
    //console.log('1. test on page - ', this.testList);
  },
  mounted(){
      this.loadImage();
  },
  methods:{
    /*getThisTest(id){
      getTest(id).then((request) => {
        this.testList = request.data.questions;
        this.bgImg = request.data.main_image;
        console.log('123', this.bgImg);
        console.log( 'test - ', this.testList );
      })
    }*/
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
        let src = this.imgSrc + '/storage/images/tests/' + this.bgImg;
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
