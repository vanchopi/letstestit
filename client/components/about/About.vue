<template>
  <div class="slider-wrapper search-result__wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <div class="category-title">          
          <span>{{$t('about')}}</span>
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

<style scoped>

</style>
