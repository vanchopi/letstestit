<template>
  <div class="slider-wrapper search-result__wrapper">

    <svg viewBox="0 0 500 150" preserveAspectRatio="none" class="wave-bg" style="width: 100%;">
      <!--<path d="M0.00,30.98 C142.99,131 271.49,-53.98 500.00,41.98 L500,0.00 L0.00,0.00 Z" style="stroke: none;"></path>-->
      <path d="M-3.67,33.05 C240.12,132.72 328.72,-30.09 502.54,33.05 L517.77,-10.36 L0.00,0.00 Z" style="stroke: none;"></path>
    </svg>
    

    <div class="switcher-wrapper">
      <div class="container">
        <div class="category-title">          
          <span>{{$t('about')}} "{{$t('main_title')}}"</span>
        </div>
      </div>    
    </div>

    <div class="content-wrapper">
      <div class="container">
        <div class="content-categories__wrapper">
          
        </div>
      </div>    
    </div>      
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import { getCategoriesList } from '~/api/categories/category'
import TextLoader from '~/components/global/TextLoader'

export default {
  name: 'About',
  //props: [],

  components: {  
    TextLoader,  
  },
  data: () => ({
    imgSrc: process.env.appRoot,    
  }),

  computed: {
    ...mapGetters({
      //user: 'auth/user',      
    }),    
    ...mapState({
      //categoriesList: state => state.categories.categories,     
    })
  },
  watch:{    
    /*'searchPages'(){        
        this.checkForMore();
    }*/
  },
  created(){           
  },
  mounted(){
  },
  destroyed() {      
  },
  methods: {    
  }
}
</script>

<style scoped lang="scss">
  @import '~assets/sass/_variables.scss';
  .wave-bg{
      /*display: inline-block;*/
      position: absolute;
      top: -50px;
      z-index: 0;
      left: 0;      
      fill: $main-color;
  } 
  .catalog-slider__wrapper .category-title{
      color: $main-text-color;
  }    
</style>
