<template>
  <div class="banner-wrapper">
    <div class="container">
      <div class="banner-image__wrapper">
        <img src="../assets/images/png/banner.png" alt="">
      </div>
      <div class="banner-description__wrapper">
        <div class="wrapper">
          <h1 class="title">
            {{$t('main_title')}}
          </h1>
          <div class="banner-desc">
            Тесты - которые смогут раскрыть каждого
          </div>
        </div>
        <div class="wrapper">
          <div class="subscribe-bt__wrapper">
            <div class="subscribe-bt">ПОДПИСАТЬСЯ</div>
          </div>
          
          <div class="socials-wrapper">
            <ul>
              <li class="item">
                <a href="#">
                  <img src="../assets/images/png/vk.png" alt="">
                </a>
              </li>
              <li class="item">
                <a href="#">
                  <img src="../assets/images/png/instagram.png" alt="">
                </a>
              </li>
              <li class="item">
                <a href="#">
                  <img src="../assets/images/png/facebook.png" alt="">
                </a>
              </li>
              <li class="item">
                <a href="#">
                  <img src="../assets/images/png/twitter.png" alt="">
                </a>
              </li>
            </ul>
          </div>
        </div>  
      </div>
    </div>  
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import LocaleDropdown from './LocaleDropdown'

export default {
  components: {    
  },

  data: () => ({
    
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    
  }
}
</script>

<style scoped>

</style>
