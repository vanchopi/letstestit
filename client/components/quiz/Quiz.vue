<template>
  <div class="quiz-wrapper" :key="quizStep">  

    <div  class="quiz-item" 
          v-for="(item, index) of getPart(quizStep)"
          :key="index"
      >
      <div class="quiz-item__info">
        <div class="back-bt">назад</div>
        <div class="counter">
          <b>5</b>
          <span>/11</span>
        </div>
      </div>
      <div class="title">
       {{item.queston}}
      </div>
      <div class="answers">
        <ul>
          <li>
            <label class="check-container">Bouquets
              <input type="radio" name="radio" value="Bouquets" data-wlradio="0">
              <span class="checkmark"></span>
            </label>
          </li>          
        </ul>
      </div>
      <div class="button-wrapper">
        <button class="custom-bt">
          <span>
            ОТВЕТИТЬ
          </span>
        </button>
      </div>  
    </div>

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
    testList: [{}],
    qurrentPart: null,
    userAnswers: [],
    quizStep: 0
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    console.log('1.quizList', JSON.parse(JSON.stringify(this.quizList)) );      
  },
  methods: {        
    getPart( num ){
      this.qurrentPart = {};
      this.qurrentPart = {
        num: JSON.parse(JSON.stringify(this.quizList[num].num)),
        queston: JSON.parse(JSON.stringify(this.quizList[num].queston)),
        answers: JSON.parse(JSON.stringify(this.quizList[num].answers))
      }

      console.log('5.qurrentPart', this.qurrentPart);
      return this.qurrentPart;
    }
  }
}
</script>

<style scoped>

</style>
