<template>
  <div class="slider-wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">        
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
            <li v-for="(category, index) of categoriesList"
                class="category-item"
                :key=index                
              >
              <div class="category-item__internal" 
                   :style="{ background: 'url(' + category.img + ')' }"
                  >
                  <!--<div class="img-wrapper">
                      <img :src="category.img" alt="">
                  </div>-->
                  <div class="link-wrapper">
                      <!--<router-link :to="{ name: category.url }" class="link"> -->
                      <router-link :to="{ name: 'category', params: {url: category.url} }" class="link">   
                        {{ category.title }}
                      </router-link>
                  </div>  
              </div>
            </li>
          </ul>
        </div>

      </div>    
    </div>  
    <!--<div class="show-more__button" @click="getMore()">
      <img src="~assets/images/png/down.png" alt="">
    </div>-->
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
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
    currentCategory: null, 
    numStep: 0,
    loader: true
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
    openFilter( id ){
      console.log(' filter ', id);
      this.showFilter[id].filter = !this.showFilter[id].filter;
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
  }
}
</script>

<style scoped>

</style>
