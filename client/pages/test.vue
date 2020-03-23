<template>
  <div>    
    <!--
    <quiz :ifCatalog="true" />-->
    <div class="test-wrapper" style="background: url(/tests/1.png);">
      <div class="container">
        test
        <quiz :quizList="currentTest"/>
        <!--<advertising />-->
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Quiz from '~/components/quiz/Quiz'
//import Advertising from '~/components/advertising/Advertising'
import { getTest } from '~/api/test/test'

export default {
  layout: 'default',

  components: {
    Quiz,
    //Advertising
  },

  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName,
    query:{
      id: 1,
      category: 'films'
    },
    currentTest:[]
  }),  

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){
    this.getTest();
  },
  methods:{
    fakeTest(){
      let testArr = [];
      for (let i = 0; i < 6; i++){        
        testArr[i] = {                     
          num: i,
          queston: 'Ты чё, э' + i + '?',
          answers: [
            { id: 0, dsc: 'ни чё'},
            { id: 1, dsc: 'а чё?'},
            { id: 2, dsc: 'и чё?'},
            { id: 3, dsc: 'а сам чё?'}
          ]
        }
      }
      return testArr;
    },
    async getTest(){
      try{
        const list =  /*await getTest(this.query)*/ this.fakeTest();        
        return this.currentTest = list;
      }catch(e){
        console.log(e);
      }
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
