<template>
  <div  class="quiz-wrapper"        
        :key="quizStep"     
        v-if="testResults == null"   
    >      
    <div  class="quiz-item" 
                              
      >
      <div class="quiz-item__info">
        <div  class="back-bt" 
              @click="goBack"
        >назад</div>
        <div class="counter">
          <b>{{testPart.id + 1}}</b>
          <span>/{{testLenght}}</span>
        </div>
      </div>
      <div class="quiz-item__content" :class="{'fade-out': fade, 'with-image': testPart.img != undefined ||  testPart.img != null}">
        <div class="question-img" v-if=" testPart.img != undefined ||  testPart.img != null">
          <FsLightbox
            class="lightbox"
            type="image"
            :types="['image']"
            :toggler="toggler"
            :sources="[
            imgSrc + '/storage/images/questions/' + testPart.img,            
            ]"
          />
          <div @click="toggler = !toggler" class="img-lightbox">
            <img :src=" imgSrc + '/storage/images/questions/' + testPart.img" alt="">
          </div>          
        </div>
        <div class="quiz-item__internal">
          <div class="title">
           {{testPart.question}}
          </div>        
          <div class="answers">
            <ul>
              <li v-for="(item, index) of testPart.answers"
                  :key="index"
                >
                <label class="check-container">{{item.dsc}}
                  <input  type="radio" 
                          name="radio" 
                          :value="item" 
                          data-wlradio="0" 
                          v-model="answer"
                          :change="getAnswer()"
                  >
                  <span class="checkmark"></span>
                </label>
              </li>          
            </ul>        
          </div>        
        </div>
      </div>  
      <div class="button-wrapper">
        <button class="custom-bt" @click="getPart(testPart.id)" v-if="quizStep < testLenght - 1">
          <span>
            ОТВЕТИТЬ
          </span>
        </button>
        <button class="custom-bt" @click="finishTest(testPart.id)" v-else>
          <span>
            ЗАВЕРШИТЬ ТЕСТ
          </span>
        </button>
      </div>  
    </div>

  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import { getTest } from '~/api/test/test'
import FsLightbox from "fslightbox-vue";
import loader from '~/store/loader.js'

export default {
  components: { 
    FsLightbox,
  },
  props: ['info', 'test', 'category', 'restartTest'],
  data: () => ({
    imgSrc: process.env.appRoot ,
    fade: false,
    toggler: false,    
    testList: [],
    testPart: [{
      id: 0,      
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

  computed:{
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      testResults: state => state.test.results,      
    })
  },  
  watch:{
      'restartTest'(){
          if (this.restartTest) {
              this.quizStep = 0;
              this.getData();
          }
      }
  },
  created(){
    this.query = this.$route.query.id;
    console.log(this.query);
    this.getData();
  },  
  mounted() {
    console.log('**',this.query);    
  },
  methods: {        
    getPart( num ){     
        if(this.answer != ''){
          this.fade = !this.fade;
          this.userAnswers[num] = this.answer;
          this.answer = ''
          if ( this.quizStep < this.testLenght - 1){
            this.quizStep++;
            this.testPart = this.testList[this.quizStep];
            console.log('quizStep', this.quizStep);          
          };
          setTimeout(() => { this.fade = !this.fade; }, 300);
          console.log('userAnswers', this.userAnswers);
        }else{
          console.log('!empty answer!');
        }  
    },
    finishTest( num ){
      if(this.answer != ''){
        this.getPart( num );
        console.log('this.testList.category_url - ', this.test);
        //this.$router.push({name: 'results', query:{id: this.query}, params:{id: this.query, url1: this.category, answers: this.userAnswers}});
        console.log('id - ', this.query);
        //loader.dispatch("changeLoading", true);
        //loader.dispatch("test/chageTxtLoading", 'Вычисляем результат');
        loader.dispatch("changeLoading", true);
        this.$store.dispatch("test/setTestResults", { id: this.query, answers: this.userAnswers });
      }
    },    
    getAnswer(){

    },
    goBack(){
      console.log('go back');
      if ( this.quizStep > 0){
        this.fade = !this.fade;
        this.quizStep--;
        this.testPart = this.testList[this.quizStep];
        setTimeout(() => { this.fade = !this.fade; }, 300);
      }else{
        this.$router.push({name: 'category', params: {url: this.category}});
        //console.log(this.category);
      }
    },
    getData(){
        this.testList = this.test;
        this.testLenght = this.testList.length;
        this.testPart = this.testList[0];
        console.log('this.testPart', this.testPart);      
    }
  }
}
</script>

<style scoped>

</style>
