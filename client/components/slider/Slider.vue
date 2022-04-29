<template>
  <div class="slider-wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <div class="switcher-wrapper__internal" id="swither-wrapper-internal">          
          <div class="arrows-wrapper">
            <div class="arrow left" 
                 :class="[ (!ifLeftAvaliable ? 'disabled' :''), (onLoad ? 'on-load' : '')]"
                 @click="sliderSwitcher('left')"
              >
              <img src="~assets/images/png/arrow-l.png" alt="arrow">
            </div>
            <div class="arrow right" 
                 :class="[ (!ifRightAvaliable ? 'disabled' : ''), (onLoad ? 'on-load' : '') ]"
                 @click="sliderSwitcher('right')"
              >
              <img src="~assets/images/png/arrow-r.png" alt="arrow">
            </div>
          </div>
          <div class="description-wrapper">
            <text-loader :loader="onLoad"/>
            <ul id="switch-category">
              <li v-for="(item, index) of categories" 
                  :key=index
                >
                <router-link :to="{ name: 'category', params: {url: item.url} }" v-if="item.url != '0'">
                  {{ item.title }}
                </router-link>
                <span v-else>
                  {{ item.title }}
                </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="content-wrapper">
      <div class="container">
        <!--
        <div  class="content-filters__wrapper">
          <div  class="filter" 
                v-for="(item, index) of filters"
                :class="{'show': showFilter[index].filter}"
                >
            <div class="title-wrapper" @click="openFilter(item.id)">
              <span class="title">
                {{ item.desc }}
              </span>
            </div>
            <div class="options-wrapper">
              <ul>
                <li v-for="option of item.options">
                  {{ option.desc }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        -->

        <div class="content-categories__wrapper">
          <ul v-if="!ifEmptyCategory">

            <li v-for="(test, index) of testsList"                 
                :key=index
              >
              <div class="item">
                <div class="img-wrapper">
                  <!--<img :src="'/_nuxt/client/assets/images/cards/' + test.img" alt="">-->
                  <img :src="imgSrc + '/storage/images/cards/' + test.bg_image" alt="">
                </div>
                <div class="description-wrapper">
                  <div class="description-wrapper__top">
                    <div class="tags">
                      <router-link  class="tag" 
                                    v-for="item of test.tags"
                                    :to="{ name: item.url }"
                                    :key="item.title"
                      >                       
                        {{ item.title }}
                      </router-link>                      
                    </div>
                    <div class="title">
                      {{ test.title }}                      
                    </div>
                  </div>
                  <div class="description-wrapper__bottom">
                    <router-link :to="{ name: 'test', query: { id: test.id, }, params: { url1:test.category_url, url2: test.url, img: test.main_image} }" class="base-button"> 
                      УЗНАТЬ
                    </router-link>
                  </div>
                </div>
              </div>
            </li>

          </ul>
          <div v-else class="empty-category__wrapper">
            <span>{{$t('ouch')}}</span>
          </div>
        </div>

      </div>    
    </div>  
    <div class="show-more__button" 
         @click="getMore()"
         v-if="ifShowMore && !ifEmptyCategory"
      >
      <img src="~assets/images/png/down.png" alt="">
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import { sliderAdaptive, switcher, startSwitcher } from './sliderController'
import { getCategoriesList } from '~/api/categories/category'
import { getTestsList, getMoreTests } from '~/api/test/test'
import TextLoader from '~/components/global/TextLoader'

export default {
  components: {  
    TextLoader,  
  },
  //props: ['ifCatalog'],
  data: () => ({
    imgSrc: process.env.appRoot,
    ifShowMore: true,
    ifLeftAvaliable: false,
    ifRightAvaliable: true,
    ifEmptyCategory: false,
    catId: 0,
    onLoad: true,
    showMore: 0,
    tmp: 0,
    showFilter: [
      { filter: false },
      { filter: false }
    ],
    categories: [ 
      { id:0, title: '', url: ''} 
    ],
    filters:[
      {
        id: 0,
        desc: 'категории',
        options: [
          { id: 0, desc: 'category1'},
          { id: 1, desc: 'category2'},
        ]
      },
      {
        id: 1,
        desc: 'популярное',
        options: [
          { id: 0, desc: 'популярное1'},
          { id: 1, desc: 'популярное2'},
        ]
      }
    ],
    testsList: [],
    categoriesList:[], 
    currentCategory: 0, // 0 - popular tests
    numStep: 0,
    loader: true
  }),

  async fetch(/*{ store, params }*/) {    
    this.categories = this.commonCategories.slice();
    this.loader = false;
    this.onLoad = false;
    this.categories = this.addPopular(this.categories);       
    try{
      this.numStep = 0;
      this.testsList = {};
      const  list  =  await getTestsList( this.currentCategory );                                      
      this.testsList = list.data.tests;      
      if (this.testsList.length){
        this.ifEmptyCategory = false;
      }else{
        this.ifEmptyCategory = true;
      }
      return this.testsList;
    }catch(e){
      console.log(e);
    }    
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      commonCategories: state => state.categories.categories,     
    })
  },
  created(){
    // console.log('slider categories - ', this.commonCategories); 
  },
  mounted(){    
    startSwitcher();
    this.checkWidth();
    window.addEventListener("resize", this.checkWidth);//magia No slaida
  },
  updated(){
    this.checkWidth();
  },
  destroyed() {
    window.removeEventListener("resize", this.checkWidth);
  },
  methods: {
    opa(){
    },
    sliderSwitcher( direction ){   
      this.onLoad = true;
      switcher(direction);
      switch(direction) {
        case 'right':
          if(this.catId == this.categories.length - 2){
            this.ifRightAvaliable = false;          
          }          
          this.catId++;          
          this.ifLeftAvaliable = true;
          if ( this.catId >= this.categories.length ){
              this.catId = this.categories.length - 1 ;
              this.ifRightAvaliable = false;
              return;
          }
          this.ifShowMore = true;          
          this.getTestsListLocal(this.catId);
          break;
        case 'left': 
          if (this.catId == 1) {            
            this.ifLeftAvaliable = false;            
          }          
          this.catId--;
          this.ifRightAvaliable = true;
          if (this.catId < 0) {
            this.catId = 0;
            this.ifLeftAvaliable = false;
            return;
          }
          this.ifShowMore = true;          
          this.getTestsListLocal(this.catId);
          break;     
      }
    },
    checkWidth(e){
      sliderAdaptive();
    },
    openFilter( id ){
      console.log(' filter ', id);
      this.showFilter[id].filter = !this.showFilter[id].filter;
    },
    checkIfMoreTests( quantity, rnum ){
      let qty = this.testsList.length;
      if( quantity > 0 && quantity >= rnum ){
        this.ifShowMore = true;        
      }else{
        this.ifShowMore = false;
      }
    },
    getTestsListLocal( num ){
        this.currentCategory = this.categories[num].id;
        this.getTests(this.currentCategory);
    },
    addPopular( arr ){
      arr.unshift({
          id: 0,
          title: this.$t('popular_tests'),
          description: '',
          url: '0',
      })
      return arr;
    },   
    async getTests( currentCategory ){
      try{
        this.numStep = 0;
        this.testsList = {};
        const  list  =  await getTestsList( currentCategory );
        this.onLoad = false;
        this.testsList = list.data.tests;
        if (this.testsList.length){
          this.ifEmptyCategory = false;
        }else{
          this.ifEmptyCategory = true;
        }
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },      
    async getMore(){      
      let id = this.testsList.length ? this.testsList[this.testsList.length - 1].id : null;
      this.numStep++;
      try{
        const  list  =  await getMoreTests(this.numStep, this.currentCategory, false, id);
        for (let i = 0; i < list.data.tests.length; i++){
          this.testsList.push(list.data.tests[i])
        }      
        this.checkIfMoreTests(list.data.quantity, list.data.rnum);  
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },        
  }
}
</script>

<style lang="scss">
  .on-load{
    opacity: 0.5 !important;
    pointer-events: none;
  }
</style>
