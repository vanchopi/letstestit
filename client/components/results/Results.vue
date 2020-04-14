<template>
  <div >      

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
                    <img src="~assets/images/png/vk.png" alt="">
                  </a>
                </li>
                <li class="item">
                  <a href="#">
                    <img src="~assets/images/png/instagram.png" alt="">
                  </a>
                </li>
                <li class="item">
                  <a href="#">
                    <img src="~assets/images/png/facebook.png" alt="">
                  </a>
                </li>
                <li class="item">
                  <a href="#">
                    <img src="~assets/images/png/twitter.png" alt="">
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

export default {
  components: {    
    //Advertising
    Breadcrumbs
  },
  props: ['info'],
  data: () => ({
    imgSrc: process.env.appRoot + '/images/results/',    
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    this.query = this.$route.params.id;
    console.log(this.query);    
  },
  mounted() {
    
  },
  methods: {              
  }
}
</script>

<style scoped>

</style>
