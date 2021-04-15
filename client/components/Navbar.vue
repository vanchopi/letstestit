<template>
  <nav class="navbar navbar-expand-lg navbar-light">    
    <div class="container">      
      <div class="nav-wrapper">  
        <div class="menu-bt mobile" @click="showMobileMenu = !showMobileMenu">
          <img src="~assets/images/svg/menu.svg" alt="menu">
        </div>      
        <router-link :to="{ name: 'welcome' }" class="logo">
          <img src="~assets/images/svg/logo.svg" alt="logo">
        </router-link> 
        <div class="serach-wrapper block mobile"
             @click="ifShowSearch = true"
          >
          <div class="search-wrapper__open">
            <img src="~assets/images/svg/search1.svg" alt="search">
          </div>          
        </div>       
        <div class="nav-menu" 
             :class="{'show': showMobileMenu}"
        >
        <div class="nav-menu__wrapper">
          <div class="menu-title mobile">
            <span>{{$t('menu')}}</span>
            <span @click="showMobileMenu = !showMobileMenu">
              <b>+</b>
            </span>
          </div>
          <ul class="nav-menu__list">
            <li>
              <router-link :to="{ name: 'catalog' }"
                            @click.native="showMobileMenu = true"
                > 
                КАТЕГОРИИ
              </router-link>
            </li>
            <li>
              <router-link  :to="{ name: 'about' }"
                            @click.native="showMobileMenu = true"
                > 
                {{$t('about')}}
              </router-link>
            </li>
          </ul>
          <div v-for="item in testfetch">{{item.id}}</div>
          <div  class="mobile-menu-block__wrapper"
                :class="{'show': showMenu}"
            >
            <ul class="container">
              <li v-for="(item, index) of categoriesList" 
                  :key=index                  
              >
                <router-link  :to="{ name: 'category', params: {url: item.url} }" 
                              @click.native="showMobileMenu = !showMobileMenu"
                  >
                  {{ item.title }}
                </router-link>
              </li>
            </ul>
          </div>
          <div class="menu-bt nav-block block">
            <div class="bt-wrp" @click="showMenu = !showMenu">
              <img src="~assets/images/svg/menu.svg" alt="menu">
              <!-- <span>MENU</span> -->
            </div>            
          </div>
          <div class="serach-wrapper block descktop"
               @click="ifShowSearch = true"
            >
            <div class="search-wrapper__open">
              <img src="~assets/images/svg/search1.svg" alt="search">
            </div>            
          </div>
          <ul class="navbar-nav block">
            <locale-dropdown />
          </ul>
        </div>  
        </div>  
      </div>
    </div>

    <search :ifShow = "ifShowSearch" :onSearchClose="onSearchClose"/>

    <div  class="menu-block__wrapper"
          :class="{'show': showMenu}"
      >
      <ul class="container">
        <li v-for="(item, index) of categoriesList" 
            :key=index            
        >
          <router-link  :to="{ name: 'category', params: {url: item.url} }"
                        @click.native="showMenu = !showMenu"
            >
            {{ item.title }}
          </router-link>
        </li>
      </ul>
    </div>
    <div  class="dark-overlay mobile"
          :class="{'show': showMobileMenu}"
          @click="showMobileMenu = !showMobileMenu"
    ></div>
    <main-loader />
  </nav>  
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import Search from './search/Search'
import MainLoader from '~/components/global/MainLoader'
import { getCategoriesList } from '~/api/categories/category'

export default {
  components: {
    LocaleDropdown,
    Search,
    MainLoader
  }, 

  data: () => ({
    appName: process.env.appName,
    searchStr:'',
    showMenu: false,
    showMobileMenu: false,
    testfetch: null,
    newCategoriesList: null,
    ifShowSearch: false,
  }),

  async fetch(/*{ store, params }*/) {        
    //console.log('api - ', process.env.apiUrl);
    let url = process.env.apiUrl + '/categories/getlist'
    this.testfetch = await fetch(new URL(url)).then(res => res.json())
    .then((data) => {
        //console.log('fetch response - ', data);
        this.$store.dispatch("categories/setCategories", data);
        //store.commit('SET_CATEGORIES', data);
        //console.log('fetch this.testfetch - ', this.testfetch);
    });
  },

  watch:{
      'categoriesList'(){
        console.log('categoriesList - ', this.categoriesList);
      }
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
  created(){    
    //this.$store.dispatch("categories/fetchCategories");
    /*console.log('newCategoriesList', this.newCategoriesList);
    console.log('1. *** testfetch - ', this.testfetch);*/
  },
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    onSearchClose(){
        this.ifShowSearch = false;
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
