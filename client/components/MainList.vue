<template>
  <div class="main-list__wrapper"> 
    <div class="container">   
      <div class="categories-list__wrapper">
        <ul>
          <li class="item"
              v-for="(item,index) in categoriesList"
              :key="item.id"
              v-if="categoriesList && categoriesList.length > 0 && index <= limit"
              :class="((index % 2) !== 0) ? 'even' : 'odd'"
          >
              
              <router-link :to="{ name: 'category', params: {url: item.url} }" class="img-wrp">
                  <img :src="item.img" alt="image">
                  <!--<div class="overlay"></div>-->
              </router-link>
              <div class="dsc-wrp">
                <div class="description">
                  <b>{{item.title}}</b>
                  <span>{{item.description}}</span>
                </div>
                <router-link :to="{ name: 'category', params: {url: item.url} }" class="link dark-link">   
                  к тестам...
                </router-link>
             </div>
            <!--</div>-->
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapState } from 'vuex'

export default {
  name: 'MainList',

  data: () => ({ 
    limit: 2,   
  }),
  created(){      
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      //newCategoriesList: state => state.categories.categories, 
      categoriesList: state => state.categories.categories,     
    })
  },
  watch:{
      /*'loader'(){
        this.ploader = this.loader;
      }*/
  },
}
</script>

<style lang="scss">
  
</style>
