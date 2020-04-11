<template>
  <div>    
    
    <!--
    <quiz :ifCatalog="true" />-->
    <div class="test-wrapper" :style="{ background: 'url(' + imgSrc + 'dobbie.jpg)'}">
      <div class="results-wrapper">
        <breadcrumbs />
        <div class="container">
          <div class="results-wrapper__internal">
            <div class="result">Ты - Добби</div>
            <div class="description">
              Судьба была неблагосклонна: твое предназначение — быть на посылках у настоящих волшебников. Но смелость, благородство и вера в добро помогли тебе добиться самого желанного — свободы. Наглядный пример того, что даже один в поле может быть еще каким воином.
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
            <div class="button-wrapper">
              <button class="custom-bt bg-tr" >
                <span>
                  ПРОЙТИ ТЕСТ ЕЩЕ РАЗ
                </span>
              </button>
            </div>
          </div>
          <!--<advertising />-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Breadcrumbs from '~/components/Breadcrumbs'
//import Advertising from '~/components/advertising/Advertising'


export default {
  layout: 'light',

  components: {    
    //Advertising
    Breadcrumbs
  },

  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: process.env.appName,    
    imgSrc: process.env.appRoot + '/images/results/', 
    testInfo: {}
  }),  

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  created(){    
    /*this.testInfo = {
        id: this.$route.params.id,
        category: 'films'
    }*/
  },
  methods:{
    
    
  }
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.laravel {
  color: #2e495e;
}

.nuxt {
  color: #00c48d;
}
</style>
