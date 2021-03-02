<template>
  <div class="slider-wrapper search-result__wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <div class="category-title">          
          <span class="txt">{{$t('search_by')}}</span>
          <span class="request">
            {{search}}
            <text-loader :loader="loader"/>
          </span>
        </div>
      </div>    
    </div>

    <div class="content-wrapper">
      <div class="container">
        <div class="content-categories__wrapper">
          <ul>

            <li v-for="(test, index) of testsList"                 
                :key=index
              >
              <div class="item">
                <div class="img-wrapper">
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
import { getCategoriesList } from '~/api/categories/category'
import { getTestsList, getMoreTests } from '~/api/test/test'
import TextLoader from '~/components/global/TextLoader'

export default {
  name: 'SearchResult',
  props: ['search'],

  components: {  
    TextLoader,  
  },
  data: () => ({
    imgSrc: process.env.appRoot,
    ifShowMore: true,
    catId: 0,
    showMore: 0,  
    categories: null,    
    testsList: [], 
    currentCategory: null, 
    numStep: 0,
    loader: false,
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      categoriesList: state => state.categories.categories,
    })
  },
  created(){           
  },
  mounted(){    
  },
  destroyed() {    
  },
  methods: {    
    async getTests(){
      try{
        this.numStep = 0;
        this.testsList = {};
        const  list  =  await getTestsList( this.currentCategory, true );
        this.testsList = list.data.tests;                
        return this.testsList;
      }catch(e){
        console.log(e);
      }
    },      
    async getMore(){      
      let id = this.testsList.length ? this.testsList[this.testsList.length - 1].id : null;
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
