<template>
  <div class="quiz-wrapper">   
    
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import LocaleDropdown from './LocaleDropdown'
//import {sliderAdaptive} from './adaptive'

export default {
  components: {    
  },
  props: ['quizList'],
  data: () => ({    
    testList: [],
    userAnswers: []
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    console.log('1.quizList', JSON.parse(JSON.stringify(this.quizList)) );  
    this.testList = JSON.parse(JSON.stringify(this.quizList));
  },
  methods: {        
    getTest(){
      return this.testList;
    },    
  }
}
</script>

<style scoped>

</style>
