<template>
  <div class="search-wrapper"
       :class="{'show': showSearch}"
      >
      <div class="container">
          <form ref="form" action=""
                @submit.prevent="searchOnSubmit"
              >
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

  props: ['ifShow', "onSearchClose"],
  data: () => ({    
    ploader: true,
    showSearch: false,
    searchStr: '',
  }),
  created(){    
      this.showSearch = this.ifShow;
  },
  watch:{
      'ifShow'(){
        this.showSearch = this.ifShow;        
      }
  },
  methods:{
      onClose(){
          this.onSearchClose();
      },
      searchOnSubmit(){
          this.onClose();
          //console.log('searchOnSubmit - ', this.searchStr);
          if(!this.searchStr == ''){
            this.$router.push({name: 'search', query:{q: this.searchStr}});
          }else{
            console.log('empty search request');
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
