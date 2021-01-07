<template>
  <footer class="footer-wrapper">

    <div class="footer-top__wrapper">
      <div class="container">
        <div class="row">        
          <div class="col-md-7">
            <div class="bottom-menu__wrapper row">
              <ul>                  
                <li v-for="(item, index) of categoriesList" 
                    :key=index                  
                >
                  <router-link  :to="{ name: 'category', params: {url: item.url} }">
                    {{ item.title }}
                  </router-link>
                </li>
              </ul>
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
import { mapGetters, mapState } from 'vuex'

export default {
  components: {
    
  },

  data: () => ({
    appName: process.env.appName,
    searchStr:'',
  }),

  watch:{
      /*'categoriesList'(){
        console.log('categoriesList from footer - ', this.categoriesList);
      }*/
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',      
    }),    
    ...mapState({
      categoriesList: state => state.categories.categories,     
    })
  },

  created(){
      console.log('3. categoriesList - ', this.categoriesList);
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
</style>
