<template>
  <div class="slider-wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <!--
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
              <li v-for="(item, index) of newCategoriesList" 
                  :key=index
                >
                {{ item.txt }}
              
              </li>
            </ul>
          </div>
        </div>-->
        <div class="category-title">
          <span v-if="true">Категории</span>
          <span v-else>123</span>
        </div>
      </div>    
    </div>

    <div class="content-wrapper">
      <div class="container">
        <div class="content-categories__wrapper">
          <ul>
            <li v-for="(category, index) of categories"
                class="category-item"
                :key=index
              >
              <div class="img-wrapper">
                <img :src="imgSrc + '/images/categories/' + (category.id + 1) + '.png'" alt="">
              </div>
              <div class="link-wrapper">
                <!--<router-link :to="{ name: category.url }" class="link"> -->
                <router-link :to="{ name: 'category', params: {url: category.url} }" class="link">   
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
import { mapGetters, mapState } from 'vuex'
import { sliderAdaptive, switcher, startSwitcher } from './sliderController'
import { getCategoriesList } from '~/api/categories/category'
import { getTestsList, getMoreTests } from '~/api/test/test'

export default {
  components: {    
  },
  //props: ['ifCatalog'],
  data: () => ({
    imgSrc: process.env.appRoot,
    catId: 0,
    showMore: 0,
    showFilter: [
      { filter: false },
      { filter: false }
    ],
    categories: [ 
      { id:0, txt: '', url: ''} 
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
    currentCategory: null, 
    numStep: 0,
    loader: true
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      newCategoriesList: state => state.categories.categories,      
    })
  },
  created(){    
    this.$store.dispatch("categories/fetchCategories");   
    this.getCategoriesList();
    //this.getTests();    
    console.log('state - ', this.newCategoriesList);
  },
  mounted(){       
  },
  destroyed() {    
  },
  methods: {
    /*sliderSwitcher( direction ){      
      console.log('direction', switcher(direction));
      switch(direction) {
        case 'right':  
          this.catId++;
          //console.log('1.length - ', this.categories);
          if ( this.catId >= this.categories.length ){
              this.catId = this.categories.length - 1 ;
              return;
          }
          this.getTestsListLocal(this.catId);
          break;
        case 'left':
          this.catId--;
          if (this.catId < 0) {
            this.catId = 0;
            return;
          }
          this.getTestsListLocal(this.catId);
          break;     
      }
    },*/
    checkWidth(e){
      console.log(sliderAdaptive());      
    },
    openFilter( id ){
      console.log(' filter ', id);
      this.showFilter[id].filter = !this.showFilter[id].filter;
    },
    getTestsListLocal( num ){
        console.log('swithed category id - ', num ,' -', this.categories[num]);
        this.currentCategory = this.categories[num];
        this.getTests(this.currentCategory);
    },
    async getCategoriesList(){      
      try{
        const  list  =  await getCategoriesList();                        
        
        this.categories = Object.freeze(list.data);       
        this.loader = false;
        console.log('11-', this.categories);
        return this.categories;
      }catch(e){
        console.log(e);
      }
    },  
    async getTests( currentCategory ){      
      try{
        const  list  =  await getTestsList( currentCategory );
        //this.categories = Object.freeze(list.data[0]);        
        this.testsList = list.data;
        console.log(' tests ',this.testsList);
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },      
    async getMore(){
      this.numStep ++;
      try{
        const  list  =  await getMoreTests(this.numStep);                                                       
        for (let i = 0; i < list.data.length; i++){
          this.testsList.push(list.data[i])
        }        
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
