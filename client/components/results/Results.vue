<template>
  <div v-if="testResults != null">      

    <!--<div class="test-wrapper" :style="{ background: 'url(' + imgSrc + '/storage/images/results/' + testResults.img + ')'}">-->
      <div class="results-wrapper">  
          <div class="results-wrapper__internal">
            <div class="result">{{ testResults.title }}</div>
            <div v-if="testResults.correct !== null" class="correct-results">{{ testResults.correct }} {{ $t('from') }} {{testResults.questions}}</div>
            <div class="description">
              <div class="description__internal" v-html="testResults.description">
                {{ testResults.description }}  
              </div>              
            </div>
            <div class="socials-wrapper __custom">
              <share :network="'facebook'" :values="testResults" />
              <share :network="'VK'" :values="testResults" />
              <share :network="'Twitter'" :values="testResults" />                     
            </div>            
            <div class="button-wrapper">
              <!--<router-link :to="{ name: 'test' , params: { url2: 'sraniy-test'}, query: {id: testId}}" class="custom-bt bg-tr">-->                
                <span class="button base-button big"
                      @click="restartTest"
                  >
                  ПРОЙТИ ТЕСТ ЕЩЕ РАЗ
                </span>
            <!--</router-link>-->
            </div>
          </div>        
      </div>
    <!--</div>-->
    

  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import { ShareNetwork } from 'vue-social-sharing/dist/vue-social-sharing'
import share from '~/components/global/Share'
//import loader from '~/store/loader.js'

export default {
  components: {
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
    }),
    testId() {
        return this.$route.query.id; 
    }
  },
  created(){
    //this.query = this.$route.params.id;
    //console.log('---',this.query);
    console.log(' test results - ', this.testResults);
    //loader.dispatch("changeLoading", false);
  },
  mounted() {
    
  },
  methods: {
      restartTest(){
          this.$store.dispatch("test/clearTestResults");
      }            
  }
}
</script>

<style scoped lang="scss">
  .breadcrumbs-wrapper{
    padding: 0 !important;
  }
</style>
