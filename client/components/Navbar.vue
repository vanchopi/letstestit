<template>
  <nav class="navbar navbar-expand-lg navbar-light">    
    <div class="container">      
      <div class="nav-wrapper">        
        <router-link :to="{ name: 'welcome' }" class="logo">
          <img src="~assets/images/png/logo2.png" alt="logo">
        </router-link>        
        <div class="nav-menu">
          <ul class="nav-menu__list">
            <li>
              <router-link :to="{ name: 'catalog' }"> 
                ТЕСТЫ
              </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'welcome' }"> 
                РЕКЛАМА
              </router-link>
            </li>
          </ul>
          <div class="menu-bt block">
            <div class="bt-wrp" @click="showMenu = !showMenu">
              <img src="~assets/images/png/menu.png" alt="menu">
            </div>
            <div  class="menu-block__wrapper"
                  :class="{'show': showMenu}"
              >
              <ul class="container">
                <li v-for="(item, index) of newCategoriesList" 
                    :key=index
                    @click="showMenu = !showMenu"
                >
                  <router-link :to="{ name: 'category', params: {id: item.url} }">
                    {{ item.txt }}
                  </router-link>
                </li>
              </ul>
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
