<template>
  <div  class="quiz-wrapper" 
        :key="quizStep"        
    >      
    <div  class="quiz-item" 
                              
      >
      <div class="quiz-item__info">
        <div class="back-bt">назад</div>
        <div class="counter">
          <b>{{testPart.num + 1}}</b>
          <span>/{{testLenght}}</span>
        </div>
      </div>
      <div class="quiz-item__content" :class="{'fade-out': fade}">
        <div class="title">
         {{testPart.queston}}
        </div>
        <div class="answers">
          <ul>
            <li v-for="(item, index) of testPart.answers"
                :key="index"
              >
              <label class="check-container">{{item.dsc}}
                <input type="radio" name="radio" :value="item.dsc" data-wlradio="0" v-model="answer">
                <span class="checkmark"></span>
              </label>
            </li>          
          </ul>        
        </div>        
      </div>  
      <div class="button-wrapper">
        <button class="custom-bt" @click="getPart(testPart.num)" v-if="quizStep < testLenght - 1">
          <span>
            ОТВЕТИТЬ
          </span>
        </button>
        <button class="custom-bt" @click="finishTest(testPart.num)" v-else>
          <span>
            ЗАВЕРШИТЬ ТЕСТ
          </span>
        </button>
      </div>  
    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import LocaleDropdown from './LocaleDropdown'
import { getTest } from '~/api/test/test'

export default {
  components: {    
  },
  props: ['info'],
  data: () => ({
    fade: false,    
    testList: [],
    testPart: [{
      num: 0,
      queston: '',
      answers: [
        { id: 0, dsc: ''},
        { id: 1, dsc: ''},
        { id: 2, dsc: ''},
        { id: 3, dsc: ''}
      ]
    }],
    testLenght: 0,
    query:{},
    qurrentPart: null,
    userAnswers: [],
    answer: '',
    quizStep: 0
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    this.query = this.$route.params.id;
    console.log(this.query);
    //this.getTestList(this.query); 
    //console.log('this.testList', this.testList);             
    //this.fakeTest();   
    //this.testPart = this.getPart( this.quizStep );
  },
  mounted() {
    console.log('**',this.query);
    this.getData(this.query);
  },
  methods: {        
    getPart( num ){         
        console.log('num', num);
        this.fade = !this.fade;
        console.log('this.fade', this.fade);
        this.userAnswers[num] = this.answer;
        if ( this.quizStep < this.testLenght - 1){
          this.quizStep++;
          this.testPart = this.testList[this.quizStep];
          console.log('quizStep', this.quizStep);          
        };
        //this.fade = !this.fade;
        setTimeout(() => { this.fade = !this.fade; }, 300);
        console.log('userAnswers', this.userAnswers);
    },
    finishTest( num ){
        this.getPart( num );
        this.$router.push({name: 'results', params:{id: this.info.id, answers: this.userAnswers}})
    },
    fakeTest(){ 
      /*let testArr = [];     
      for (let i = 0; i < 6; i++){        
        this.testList.push({                     
          num: i,
          queston: 'Ты чё, э' + i + '?',
          answers: [
            { id: 0, dsc: 'ни чё'},
            { id: 1, dsc: 'а чё?'},
            { id: 2, dsc: 'и чё?'},
            { id: 3, dsc: 'а сам чё?'}
          ]
        })
      }           
      console.log('1.this.testList', this.testList);
      return this.testList;*/
    },
    async getTestList( info ){
      try{
        const  list  =  await getTest(info);        
        console.log('list', list.data);
        //return Object.freeze(list.data);
        return list.data;
      }catch(e){
        console.log(e);
      }
    },
    getData( info ){
      getTest(info).then((request) => {
        console.log('request', request);
        this.testList = request.data;
        this.testLenght = request.data.length;
        this.testPart = this.testList[0];
        console.log('this.testPart', this.testPart);
      })
    }
  }
}
</script>

<style scoped>

</style>
