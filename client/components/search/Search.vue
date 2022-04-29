<template>
  <div class="search-wrapper"
       :class="{'show': showSearch}"
      >
      <div class="container">
          <form ref="form" action=""
                @submit.prevent="searchOnSubmit"
              >
              <recaptcha />
              <input type="text" placeholder="Search..."
                     v-model="searchStr"
              >              
              <div class="search-bt"
                   @click="searchOnSubmit"
                  >
                  <img src="~assets/images/svg/search2.svg" alt="search">
              </div>
              <div class="close-bt"
                   @click="onClose()"
                  >
                  <img src="~assets/images/svg/cross.svg" alt="">
              </div>
          </form>
      </div>
  </div>
</template>

<script>


export default {
  name: 'Search',
  components: {  },
  props: ['ifShow', "onSearchClose"],
  data: () => ({    
    ploader: true,
    showSearch: false,
    searchStr: '',
    recaptchaKey: process.env.appRoot,
  }),
  created(){    
      this.showSearch = this.ifShow;
  },
  watch:{
      'ifShow'(){
        this.showSearch = this.ifShow;        
      },
      'searchStr'(){
          /*console.log('search str - ', this.searchStr);
          this.$store.dispatch("search/setRequest", this.searchStr );*/
      }
  },
  async mounted() {
    try {
      await this.$recaptcha.init()
    } catch (e) {
      console.log(e);
    }
  },
    beforeDestroy() {
        this.$recaptcha.destroy()
    },
    methods:{
        onClose(){
            this.onSearchClose();
        },
        async searchOnSubmit(){
            try {
                const token = await this.$recaptcha.execute('search');
                this.onClose();
                if(!this.searchStr == '' && token){
                    this.$router.push({name: 'search', query:{q: this.searchStr, token: token}});
                }else{
                    console.log('empty search request');
                }
            } catch (error) {
                console.log('Login error:', error)
            }
        }
    }
}
</script>

<style scoped lang="scss">
    @import '~assets/sass/_variables.scss';    
    .container{
        height: 100%;
        form{
            position: relative;
            width: 100%;
            height: 100%;
            @include align-center;
            justify-content: space-between;
            input{
              width: calc(100% - 62px - 30px);
              margin-right: 30px;
              height: 100%;
              border: none;
              border-radius: 5px;
              padding: 5px 75px 5px 20px;
            }
            .search-bt{
                position: absolute;
                @include align-center;
                justify-content: center;
                width: 75px;
                height: 100%;
                right: calc(62px + 30px);
                cursor: pointer;
            }
            .close-bt{
                width: 62px;
                height: 100%;
                @include align-center;
                justify-content: center;
                cursor: pointer;
                img{
                  width: 30px;
                  height: 30px;
                }
            }
        }
    }
    @media screen and (max-width: 480px){
        .container{
            form{            
                input{
                    width: calc(100% - 62px - 15px);
                    margin-right: 15px;
                }
                .search-bt{
                    right: calc(62px + 15px);
                }
            }
        }
    }
</style>
