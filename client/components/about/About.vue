<template>
  <div class="slider-wrapper search-result__wrapper">    

    <!--<svg viewBox="0 0 500 150" preserveAspectRatio="none" class="wave-bg" style="width: 100%;">
      <path d="M-3.67,33.05 C240.12,132.72 328.72,-30.09 502.54,33.05 L517.77,-10.36 L0.00,0.00 Z" style="stroke: none;"></path>
    </svg>-->

    <div class="svg-container">
      <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
        <path d="M-0.27,105.09 C252.54,150.48 271.72,-14.30 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none;"></path>
      </svg>
    </div>
    
    <div class="content-wrapper">
      <div class="container">
        <div class="category-title">          
          <span>{{$t('about')}} "{{$t('main_title')}}"</span>
        </div>      
        <div class="content-internal__wrapper">
            <div class="text-block">
                <div class="after-title">
                  Мы рады приветствовать Вас на нашем ресурсе!
                </div>
                <div class="text-content">
                  Наш сервис <router-link :to="{ name: 'welcome' }" class="dark-link">letstestit.ru</router-link> предоставляет возможность всем желающим пройти множество разнообразных тестов: от тестов по мемам до тестов по психологии. Материал размещенный на страницах данного ресурса не преследует цели кого-то оскорбить или каким-либо образом дискриминировать. Тесты, в том числе их результат(за исключением тестов на проверку знаний), носят шуточный характер. Ни в коем случае не стоит относиться к ним серьезно.                                     
                </div>
                <div class="after-title">
                  Кто составляет тесты ?
                </div>
                <div class="text-content">
                  Авторы тестов - мы сами, команда энтузиастов. Наша миссия - развеселить, в исключительных случаях - заставить подумать. Надеемся, что процесс прохождения тестов будет доставлять лишь положительные эмоции!   
                </div>
                <div class="after-title">
                  Вопросы и предложения
                </div>
                <div class="text-content">
                  Все вопросы и предложения можно отправлять на наш Email - <a class="dark-link" :href="`mailto:${mail}?subject=Let's test it. About.`">{{mail}}</a>. Также это можно сделать воспользовавшись <a class="dark-link" href="#" @click.prevent = "callForm()">формой обратной связи</a> на нашем сайте.
                </div>
            </div>
            <div class="content-block">
              <div class="title">
                Топ тестов:
              </div>
              <div class="tests-about__wrapper">
                <ul>
                  <li v-for="test in topTestsList">
                    <router-link :to="{ name: 'test', query: { id: test.id, }, params: { url1:test.category_url, url2: test.url} }" :title="test.title">
                      {{test.title}}
                    </router-link>
                  </li>
                </ul>
              </div>
            </div>
        </div>
      </div>    
    </div>
    <div class="svg-container __bottom">
      <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
        <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none;">
        </path>
      </svg>
    </div>  
    <feedback-form :showForm="showForm" :onCloseForm="onCloseForm"/>     
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import { getCategoriesList } from '~/api/categories/category'
import TextLoader from '~/components/global/TextLoader'
import FeedbackForm from '~/components/feedbackForm/FeedbackForm'

export default {
  name: 'About',
  //props: [],

  components: {  
    TextLoader,  
    FeedbackForm,
  },
  data: () => ({
    imgSrc: process.env.appRoot,
    showForm: false,
    mail: process.env.mail,    
  }),

  computed: {
    ...mapGetters({
      //user: 'auth/user',      
    }),    
    ...mapState({
      //categoriesList: state => state.categories.categories,
      topTestsList: state => state.test.topTests,     
    })
  },
  watch:{    
    /*'searchPages'(){        
        this.checkForMore();
    }*/
    'topTestsList'(){
        //console.log('watch top - ', this.topTestsList);
    }
  },
  created(){ 
    //console.log('about - ', this.topTestsList);
    if (this.topTestsList == null){
        this.$store.dispatch("test/setTopList");
    }
  },
  mounted(){
  },
  destroyed() {      
  },
  methods: {
    callForm(){
      this.showForm = true;     
    },
    onCloseForm(flag){        
        this.showForm = flag;
    } 
  }
}
</script>

<style scoped lang="scss">
  @import '~assets/sass/_variables.scss';
  .wave-bg{
      /*display: inline-block;*/
      position: absolute;
      top: -50px;
      z-index: 0;
      left: 0;      
      fill: $main-color;
  } 
  .catalog-slider__wrapper .category-title{
      color: $main-text-color;
  }  
  .svg-container{
    height: 150px;
    overflow: hidden;
    position: absolute;
    width: 100%;
    &.__bottom{
      position: relative;
      border-bottom: 1px solid rgba(86, 92, 103, 1);
    }
  }
  .svg-container{    
    svg{
      fill: $main-color;
    }
  }    
</style>
