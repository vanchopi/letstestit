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
                    <router-link :to="{ name: 'test', query: { id: test.id, }, params: { url1:test.category_url, url2: test.url, img: test.main_image} }" class="button">
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
    page: 1,
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      categoriesList: state => state.categories.categories,
      searchResult: state => state.search.result,
      searchRequest: state => state.search.request,
      searchPages: state => state.search.pages,
    })
  },
  watch:{
    'searchResult'(){
      console.log('searchResult changed');
      if(this.searchResult != null){
          this.testsList = this.searchResult.data;
          //this.checkForMore();
      }else{
          this.testsList = [];
      }      
    },
    'searchRequest'(){
        this.setDefaultData();    
    },
    'searchPages'(){
        //console.log('data pages');
        this.checkForMore();
    }
  },
  created(){           
  },
  mounted(){
  },
  destroyed() {
      this.$store.dispatch("search/clearSearchResults");
      this.$store.dispatch("search/clearRequest");
      this.setDefaultData();
  },
  methods: {
    setDefaultData(){
        this.page = 1;
        this.ifShowMore = true;
    },
    checkForMore(){        
        if (this.searchPages.to == this.searchPages.total || this.searchPages.to == null){
            return this.ifShowMore = false;
        }        
    },   
    getMore(){
        this.page++;
        this.$store.dispatch("search/moreSearchResult", { str:this.searchRequest, page: this.page } );
    }
  }
}
</script>

<style scoped>

</style>
