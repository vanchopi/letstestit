<template>
  <nav class="navbar navbar-expand-lg navbar-light">    
    <div class="container">      
      <div class="nav-wrapper">  
        <div class="menu-bt mobile" @click="showMobileMenu = !showMobileMenu">
          <img src="~assets/images/png/menu.png" alt="menu">
        </div>      
        <router-link :to="{ name: 'welcome' }" class="logo">
          <img src="~assets/images/png/logo2.png" alt="logo">
        </router-link> 
        <div class="serach-wrapper block mobile">
          <div class="search-wrapper__open">
            <img src="~assets/images/png/search.png" alt="search">
          </div>
          <div class="search-block__wrapper hidden">
            <input type="text" name="search" v-model="searchStr">
            <div class="search-bt">
              <img src="~assets/images/png/search.png" alt="search">
            </div>
          </div>
        </div>       
        <div class="nav-menu" 
             :class="{'show': showMobileMenu}"
        >
        <div class="nav-menu__wrapper">
          <div class="menu-title mobile">
            <span>Menu</span>
            <span @click="showMobileMenu = !showMobileMenu"><b>+</b></span>
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
              <router-link  :to="{ name: 'welcome' }"
                            @click.native="showMobileMenu = true"
                > 
                РЕКЛАМА
              </router-link>
            </li>
          </ul>
          <div  class="mobile-menu-block__wrapper"
                :class="{'show': showMenu}"
            >
            <ul class="container">
              <li v-for="(item, index) of newCategoriesList" 
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
              <img src="~assets/images/png/menu.png" alt="menu">
              <!-- <span>MENU</span> -->
            </div>            
          </div>
          <div class="serach-wrapper block">
            <div class="search-wrapper__open">
              <img src="~assets/images/png/search.png" alt="search">
            </div>
            <div class="search-block__wrapper hidden">
              <input type="text" name="search" v-model="searchStr">
              <div class="search-bt">
                <img src="~assets/images/png/search.png" alt="search">
              </div>
            </div>
          </div>
          <ul class="navbar-nav block">
            <locale-dropdown />
          </ul>
        </div>  
        </div>  
      </div>
    </div>
    <div  class="menu-block__wrapper"
          :class="{'show': showMenu}"
      >
      <ul class="container">
        <li v-for="(item, index) of newCategoriesList" 
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
  </nav>  
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: process.env.appName,
    searchStr:'',
    showMenu: false,
    showMobileMenu: false,
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
    console.log('newCategoriesList', this.newCategoriesList);
  },
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
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
