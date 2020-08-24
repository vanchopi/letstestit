<template>
  <div class="slider-wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <div class="switcher-wrapper__internal" id="swither-wrapper-internal">          
          <div class="arrows-wrapper">
            <div class="arrow left" @click="sliderSwitcher('left')">
              <img src="~assets/images/png/arrow-l.png" alt="">
            </div>
            <div class="arrow right" @click="sliderSwitcher('right')">
              <img src="~assets/images/png/arrow-r.png" alt="">
            </div>
          </div>
          <div class="description-wrapper">
            <text-loader :loader="loader"/>
            <ul id="switch-category">
              <li v-for="(item, index) of categories" 
                  :key=index
                >
                {{ item.title }}
               
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
          <ul>

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
                    <router-link :to="{ name: 'test', params: {id: test.id, img: test.main_image} }" class="button"> 
                      УЗНАТЬ
                    </router-link>
                  </div>
                </div>
              </div>
            </li>

          </ul>
        </div>

      </div>    
    </div>  
    <div class="show-more__button" 
         @click="getMore()"
         v-if="ifShowMore"
      >
      <img src="~assets/images/png/down.png" alt="">
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
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
    catId: 0,
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

  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    if(this.ifCatalog){
      console.log('catalog', this.ifCatalog);
    }else{
      console.log('categories', this.ifCatalog);
    }    
    this.getCategoriesList();
    this.getTests(this.currentCategory);    
  },
  mounted(){
    this.checkWidth();
    startSwitcher();
    window.addEventListener("resize", this.checkWidth);        
  },
  destroyed() {
    window.removeEventListener("resize", this.checkWidth);
  },
  methods: {
    sliderSwitcher( direction ){      
      console.log('direction', switcher(direction));
      switch(direction) {
        case 'right':  
          this.catId++;
          //console.log('1.length - ', this.categories);
          if ( this.catId >= this.categories.length ){
              this.catId = this.categories.length - 1 ;
              return;
          }
          this.ifShowMore = true;          
          this.getTestsListLocal(this.catId);
          break;
        case 'left':          
          this.catId--;
          if (this.catId < 0) {
            this.catId = 0;
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
    checkIfMoreTests( quantity ){
      let qty = this.testsList.length;
      if( quantity > 0){
        this.ifShowMore = true;        
      }else{
        this.ifShowMore = false;
      }
    },
    getTestsListLocal( num ){        
        console.log('swithed category id - ', num ,' -', this.categories[num]);
        this.currentCategory = this.categories[num].id;
        this.getTests(this.currentCategory);
    },
    addPopular( arr ){
      arr.unshift({
          id: 0,
          title: 'Популярные тесты',          
          description: '',
          url: '0',
      })
      return arr;
    },
    async getCategoriesList(){      
      try{
        const  list  =  await getCategoriesList();                        
        console.log(list);
        this.categories = list.data;
        this.loader = false;
        this.categories = this.addPopular(this.categories);
        return this.categories;
      }catch(e){
        console.log(e);
      }
    },  
    async getTests( currentCategory ){
      try{
        this.numStep = 0;
        this.testsList = {};
        const  list  =  await getTestsList( currentCategory );                                
        //this.categories = Object.freeze(list.data[0]);        
        this.testsList = list.data.tests;
        console.log(' tests ',this.testsList);        
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },      
    async getMore(){      
      let id = this.testsList.length ? this.testsList[this.testsList.length - 1].id : null;
      this.numStep ++;
      try{
        const  list  =  await getMoreTests(this.numStep, this.currentCategory, false, id);
        for (let i = 0; i < list.data.tests.length; i++){
          this.testsList.push(list.data.tests[i])
        }      
        this.checkIfMoreTests(list.data.quantity);  
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },    
    getCategories(){
      for (let i = 0; i < 9; i++){        
        this.categoriesList[i] = {            
          img: (i + 1) +'.png',
          url: '#',
          title: 'тесты по фильмам' + i,          
        }
      }      
      return this.categoriesList;
    }
  }
}
</script>

<style scoped>

</style>
