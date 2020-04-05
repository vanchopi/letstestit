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
            <ul id="switch-category">
              <li v-for="(item, index) of categories">
                {{ item.txt }}
              </li>
            </ul>
          </div>
        </div>
      </div>    
    </div>

    <div class="content-wrapper">
      <div class="container">

        <div  class="content-filters__wrapper" 
              v-if="!ifCatalog"
          >
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

        <div class="content-categories__wrapper">
          <ul>

            <li v-if="!ifCatalog"
                v-for="(test, index) of getTests()"                 
                :key=index
              >
              <div class="item">
                <div class="img-wrapper">
                  <!--<img :src="'/_nuxt/client/assets/images/cards/' + test.img" alt="">-->
                  <img :src="imgSrc + '/images/cards/' + test.img" alt="">
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
                    <router-link :to="{ name: 'test', params: {id: index} }" class="button"> 
                      УЗНАТЬ
                    </router-link>
                  </div>
                </div>
              </div>
            </li>
            
            <li v-if="ifCatalog"               
                v-for="(category, index) of getCategories()"
                class="category-item"
                :key=index
              >
              <div class="img-wrapper">
                <img :src="imgSrc + '/images/categories/' + category.img" alt="">
              </div>
              <div class="link-wrapper">
                <!--<router-link :to="{ name: category.url }" class="link"> -->
                <router-link :to="{ name: 'welcome' }" class="link">   
                  {{ category.title }}
                </router-link>
              </div>  
            </li>

          </ul>
        </div>

      </div>    
    </div>  
    <div class="show-more__button" @click="getMore()">
      <img src="~assets/images/png/down.png" alt="">
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import LocaleDropdown from './LocaleDropdown'
import { sliderAdaptive, switcher } from './sliderController'

export default {
  components: {    
  },
  props: ['ifCatalog'],
  data: () => ({
    imgSrc: process.env.appRoot,
    catId: 0,
    showMore: 0,
    showFilter: [
      { filter: false },
      { filter: false }
    ],
    categories: [ 
      { id:0, txt: 'Тесты по фильмам'}, 
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'} 
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
    categoriesList:[]
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
    //this.catLength = this.categories.length;
    //console.log(this.catLength);
  },
  mounted(){
    this.checkWidth();
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
          if ( this.catId > this.categories.length ){
              this.catId = this.categories.length;
          }
          this.getCategoryList(this.catId);
          break;
        case 'left':          
          this.catId--;
          if (this.catId < 0) {
            this.catId = 0;
          }
          this.getCategoryList(this.catId);
          break;     
      }
    },
    checkWidth(e){
      console.log(sliderAdaptive());      
    },
    openFilter( id ){
      console.log(' filter ', id);
      this.showFilter[id].filter = !this.showFilter[id].filter;
    },
    getCategoryList( id ){
        console.log('category id - ', id);
    },
    getTests(){
      for (let i = 0; i < 6; i++){        
        this.testsList[i] = {            
          img: (i + 1) +'.png',
          url: '#',
          title: 'Какой ты покемон',
          tags: [
            { title: 'Хогвартс', url: 'welcome' },
            { title: 'Хогвартс1', url: 'welcome' },
            { title: 'Хогвартс2', url: 'welcome' },
          ]
        }
      }
      return this.testsList;
    },
    getMore(){
      this.showMore++;
      console.log('er');
      for (let i = 0; i < 3; i++){
        this.testsList.push({
          img: (i + 1) +'.png',
          url: '#',
          title: 'Какой ты покемон',
          tags: [
            { title: 'Хогвартс', url: 'welcome' },
            { title: 'Хогвартс1', url: 'welcome' },
            { title: 'Хогвартс2', url: 'welcome' },
          ]
        })
      }
      return this.testsList;
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
