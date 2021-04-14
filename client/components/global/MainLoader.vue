<template>
  <div class="main-loader"
       :class="{'hide': !localLoading}"
      >
      <div class="cssload-container">
          <ul class="cssload-flex-container">
            <li>
              <span class="cssload-loading"></span>
            </li>            
          </ul>
      </div>
  </div>
</template>

<script>

import { mapGetters, mapState } from 'vuex'
import loader from '~/store/loader.js'

export default {
  name: 'MainLoader',

  props: {
    //loader: false
  },
  data: () => ({    
    ploader: true,
    localLoading: true,
  }),
  computed: {
    ...mapGetters({
      //user: 'auth/user',      
    }),    
    ...mapState({      
      //loaderState: state => state.loader.ifLoading,
    }),
    loadingGlobal () {
      let self = this;
      setTimeout(function(){
        self.localLoading = loader.state.ifLoading;
      }, 500);
      return loader.state.ifLoading;
    }
  },  
  created(){
      //console.log('pre loader - ', this.loader);
      //this.ploader = this.loader;      
      console.log('123 - ', this.localLoading);
      /*this.$store.subscribe((mutation, state) => {
        if (mutation.type === 'loader/CHANGE_LOADING') {
          console.log('SET_COOKIE', this.loaderState);
          //this.$nextTick(function () {
            //this.$store.dispatch('cookieCheck/reloadProject' );
          //})
        }
      });*/
  },
  watch:{
    /*'loaderState'(){
      console.log('321 - ', this.loaderState);
    },*/
    loadingGlobal (newCount, oldCount) {
      let self = this;
      console.log('loading - ', newCount);
      setTimeout(function(){
        self.localLoading = newCount;
      }, 500);
    }
  },  
}
</script>

<style lang="scss">
  @import '~assets/sass/_variables.scss';
  .main-loader {
    @include align-center;
    justify-content: center;
    width: 100%;
    height: 100vh;
    position: fixed;
    z-index: 10;
    top: 0;
    left: 0;
    background: $page-bg;
    visibility: visible;
    opacity: 1;
    transition: opacity .3s ease,
                visibility .3s ease;
    &.hide{
      opacity: 0;
      visibility: hidden;
    }
    .cssload-container{
      width: 97px;
      height: 97px;
    }
    .cssload-container * {
      box-sizing: border-box;
    }
    .cssload-container {
      margin: 19px auto 0 auto;
      max-width: 545px;
    }

    .cssload-container ul li{
      list-style: none;
    }

    .cssload-flex-container {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: space-around;
    }
    .cssload-flex-container li {
      padding: 10px;
      height: 97px;
      width: 97px;
      margin: 29px 19px;
      position: relative;
      text-align: center;
    }

    .cssload-loading {
      display: inline-block;
      position: relative;
      width: 83px;
      height: 83px;
      border-radius: 100%;
      border: 5px solid transparent;
      border-bottom: 5px solid rgb(54,62,75);
      border-left: 5px solid rgb(54,62,75);
      animation: cssload-spinR 0.9s linear infinite;
    }
    .cssload-loading:before, .cssload-loading:after {
      content: '';
      display: block;
      border-radius: 100%;
      position: absolute;
    }
    .cssload-loading:before {
      height: 49px;
      width: 49px;
      border: 3px solid transparent;
      border-top: 3px solid rgb(54,62,75);
      border-right: 3px solid rgb(54,62,75);
      animation: cssload-spinL 0.605s linear infinite;
      transform-origin: center center;
      top: 11%;
      left: 11%;
    }
    .cssload-loading:after {
      height: 10px;
      width: 10px;
      background: transparent;
      border: 2px solid rgb(54,62,75);
      top: 35.5%;
      left: 35.5%;
    }

    @keyframes cssload-spinR {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }

    @keyframes cssload-spinL {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(-360deg);
      }
    }
  }
</style>
