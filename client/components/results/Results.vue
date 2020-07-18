<template>
  <div >      

    <div class="test-wrapper" :style="{ background: 'url(' + imgSrc + '/storage/images/results/' + testResults.img + ')'}">
      <div class="results-wrapper">
        <breadcrumbs />
        <div class="container">
          <div class="results-wrapper__internal">
            <div class="result">{{ testResults.result }}</div>
            <div class="description">
              {{ testResults.description }}
            </div>
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
            </div>
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
//import Advertising from '~/components/advertising/Advertising'

export default {
  components: {    
    //Advertising
    Breadcrumbs
  },
  props: ['info'],
  data: () => ({
    imgSrc: process.env.appRoot,    
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
  },
  mounted() {
    
  },
  methods: {              
  }
}
</script>

<style scoped>

</style>
