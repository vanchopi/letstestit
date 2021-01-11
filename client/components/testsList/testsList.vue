<template>
  <div class="slider-wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <div class="category-title">          
          <span >
            {{ catName }}
            <text-loader :loader="loader"/>
          </span>
        </div>
      </div>    
    </div>

    <div class="content-wrapper">
      <div class="container">

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
    <div  class="show-more__button" 
          @click="getMore()"
          v-if="ifShowMore"
      >
      <img src="~assets/images/png/down.png" alt="">
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
//import { sliderAdaptive, switcher, startSwitcher } from './sliderController'
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
    /*categories: [ 
      { id:0, txt: ''} 
    ],*/
    categories: null,
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
    currentCategory: null, 
    numStep: 0,
    queryCategory: null,
    catName: null,
    loader: false,
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      //newCategoriesList: state => state.categories.categories,
      categoriesList: state => state.categories.categories,
    })
  },
  created(){
    this.queryCategory = this.$route.params.url;
    this.drawCategoriesList();       
  },
  mounted(){    
  },
  destroyed() {    
  },
  methods: {
    getCurrentCategory(){            
      let result = this.categories.filter( category => category.url == this.queryCategory);
      this.currentCategory = this.queryCategory;      
      this.getTests();
      return result.length > 0 ? this.catName = result[0].title : this.catName = 'Название категории';
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
    drawCategoriesList(){
        this.categories = this.categoriesList;
        this.getCurrentCategory();  
        //this.loader = false;      
    },
    async getTests(){
      try{
        this.numStep = 0;
        this.testsList = {};
        const  list  =  await getTestsList( this.currentCategory, true );
        this.testsList = list.data.tests;        
        //this.checkIfMoreTests(list.data.quantity);
        //console.log(' tests ',this.testsList);        
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },      
    async getMore(){      
      let id = this.testsList.length ? this.testsList[this.testsList.length - 1].id : null;
      //console.log(' last id - ', id);
      this.numStep ++;
      try{
        const  list  =  await getMoreTests(this.numStep, this.currentCategory, true, id);
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

<style scoped>

</style>
