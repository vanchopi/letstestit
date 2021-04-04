<template>
  <div class="slider-wrapper search-result__wrapper">

    <!--<svg viewBox="0 0 500 150" preserveAspectRatio="none" class="wave-bg" style="width: 100%;">
      <path d="M-3.67,33.05 C240.12,132.72 328.72,-30.09 502.54,33.05 L517.77,-10.36 L0.00,0.00 Z" style="stroke: none;"></path>
    </svg>-->

    <div class="svg-container">
      <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
        <path d="M-1.97,91.28 C149.99,150.00 271.49,-49.98 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none;"></path>
      </svg>
    </div>
    
    <div class="content-wrapper">
      <div class="container">
        <div class="category-title">          
          <span>{{$t('about')}} "{{$t('main_title')}}"</span>
        </div>      
        <div class="content-internal__wrapper">
            <div class="text-block">
                <div class="after-title">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus animi, repudiandae, laudantium porro repellendus voluptatibus quam sint commodi sequi quasi mollitia magni beatae sed odit ratione delectus velit rem voluptatum?
                </div>
                <div class="text-content">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam similique odio impedit eum omnis, porro illum magnam, laudantium cum aut perspiciatis sequi nihil sed, ab. Adipisci necessitatibus voluptas natus maxime.
                  <br>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam provident voluptatem culpa accusantium voluptatibus pariatur nostrum praesentium dolorum a tempora? Eveniet enim itaque ipsa quam saepe minima facilis aperiam odio! <br> <br>Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Iste illo aspernatur ut cum expedita, provident. Cumque, distinctio maxime debitis vero voluptatibus a id officiis fugiat iusto commodi ut veritatis blanditiis.
                </div>
            </div>
            <div class="content-block">
              <div class="title">
                Топ тестов:
              </div>
              <div class="tests-about__wrapper">
                <ul>
                  <li v-for="index in 10">
                    <a href="#">Кто ты из гарри {{index}}</a>
                  </li>
                </ul>
              </div>
            </div>
        </div>
      </div>    
    </div>
    <div class="svg-container __bottom">
      <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
        <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none;">
        </path>
      </svg>
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
  .svg-container{
    height: 150px;
    overflow: hidden;
    position: absolute;
    width: 100%;
    &.__bottom{
      position: relative;
    }
  }
  .svg-container{    
    svg{
      fill: $main-fill-color;
    }
  }  
</style>
