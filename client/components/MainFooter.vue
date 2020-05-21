<template>
  <footer class="footer-wrapper">

    <div class="footer-top__wrapper">
      <div class="container">
        <div class="row">        
          <div class="col-md-7">
            <div class="bottom-menu__wrapper row">
              <div class="col-md-6 col-sm-6 col-12">
                <ul>
                  <li v-for="index in 5" :key="index"">
                    <router-link :to="{ name: 'welcome' }"> 
                    Тесты по фильмам{{index}}
                    </router-link>
                  </li>
                </ul>
              </div>
              <div class="col-md-6 col-sm-6 col-12">  
                <ul>
                  <li v-for="index in 5" :key="index"">
                    <router-link :to="{ name: 'welcome' }"> 
                    Тесты по книгам{{index}}
                    </router-link>
                  </li>
                </ul>
              </div>  
            </div>
          </div>
          <div class="col-md-5">
            <div class="bottom-contacts__wrapper">
              <div class="wrapper">
                <div class="title">
                  КОНТАКТЫ:
                </div>
                <div class="mail">
                  <a href="mailto:test@test.ru?subject=Lets test it">
                    info@lesttestit.com
                  </a>
                </div>
              </div>
              <div class="wrapper">
                <div class="title">
                  Мы в социальных сетях
                </div>
                <div class="socials-bottom__wrapper">
                  <ul>
                    <li>
                      <a href="#">
                        <img src="~assets/images/png/vk-b.png" alt="">
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img src="~assets/images/png/instagram-b.png" alt="">
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img src="~assets/images/png/facebook-b.png" alt="">
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <img src="~assets/images/png/twitter-b.png" alt="">
                      </a>
                    </li>
                  </ul>
                </div>
              </div>  

            </div>
          </div>
        </div>
      </div>
    </div>    
    <div class="footer-bottom__wrapper">
       <span class="copyright">© 2020 Lest Test It</span>
    </div>
    </div>
    
  </footer>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  components: {
    
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
</style>
