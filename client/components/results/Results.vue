<template>
  <div >      

    <div class="test-wrapper" :style="{ background: 'url(' + imgSrc + '/storage/images/results/' + testResults.img + ')'}">
      <div class="results-wrapper">
        <breadcrumbs />
        <div class="container">
          <div class="results-wrapper__internal">
            <div class="result">{{ testResults.title }}</div>
            <div class="description">
              {{ testResults.description }}
            </div>
            <div class="socials-wrapper __custom">
              <share :network="'facebook'" :values="testResults" />
              <share :network="'VK'" :values="testResults" />
              <share :network="'Twitter'" :values="testResults" />                     
            </div>
            <!--
            <div class="socials-wrapper">
              <ul>
                <li class="item"> 
                  <a href="#">
                    <img src="~assets/images/png/vk.png" alt="">
                  </a>
                </li>
                <li class="item">
                  <a href="#">
                    <img src="~assets/images/png/instagram.png" alt="">
                  </a>
                </li>
                <li class="item">
                  <a href="#">
                    <img src="~assets/images/png/facebook.png" alt="">
                  </a>
                </li>
                <li class="item">
                  <a href="#">
                    <img src="~assets/images/png/twitter.png" alt="">
                  </a>
                </li>
              </ul>
            </div> -->
            <div class="button-wrapper">
              <!--<button class="custom-bt bg-tr" >-->
              <router-link :to="{ name: 'test', params: {id: query} }" class="custom-bt bg-tr">                
                <span>
                  ПРОЙТИ ТЕСТ ЕЩЕ РАЗ
                </span>
              <!--</button>-->
            </router-link>
            </div>
          </div>
          <!--<advertising />-->
        </div>
      </div>
    </div>
    

  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import Breadcrumbs from '~/components/Breadcrumbs'
import { ShareNetwork } from '@/../node_modules/vue-social-sharing/dist/vue-social-sharing'
import share from '~/components/global/Share'
//import Advertising from '~/components/advertising/Advertising'

export default {
  components: {    
    //Advertising
    Breadcrumbs,
    share
  },
  props: ['info'],
  data: () => ({
    imgSrc: process.env.appRoot,   
    /*values: {
      url:"https://letstestit.ru/",
      title:"Пройди тест",
      description:"Тестовый тест тестового результата",
      quote:"Тестовая цитата",
      hashtags:"letstestit",
      media:'https://letstestit.ru/images/2.jpg',
    }*/
  }),
  watch:{
      'testResults'(){
        console.log('data - ', this.testResults);
      }
  },
  computed:{
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      testResults: state => state.test.results,      
    })
  },
  created(){
    this.query = this.$route.params.id;
    console.log('---',this.query);
    console.log(' test results - ', this.testResults);
  },
  mounted() {
    
  },
  methods: {              
  }
}
</script>

<style scoped lang="scss">
  .breadcrumbs-wrapper{
    padding: 0 !important;
  }
</style>
