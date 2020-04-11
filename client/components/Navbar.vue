<template>
  <nav class="navbar navbar-expand-lg navbar-light">    
    <div class="container">      
      <div class="nav-wrapper">
        <a href="/" class="logo">
            <img src="~assets/images/png/logo2.png" alt="">
        </a>
        <div class="nav-menu">
          <ul class="nav-menu__list">
            <li>
              <router-link :to="{ name: 'welcome' }"> 
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
            <img src="~assets/images/png/menu.png" alt="">
          </div>
          <div class="serach-wrapper block">
            <div class="search-wrapper__open">
              <img src="~assets/images/png/search.png" alt="">
            </div>
            <div class="search-block__wrapper hidden">
              <input type="text" name="search" v-model="searchStr">
              <div class="search-bt">
                <img src="~assets/images/png/search.png" alt="">
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
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: process.env.appName,
    searchStr:'',
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

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
