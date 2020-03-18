<template>
  <div class="slider-wrapper" id="slider">   

    <div class="switcher-wrapper">
      <div class="container">
        <div class="switcher-wrapper__internal">          
          <div class="arrows-wrapper">
            <div class="arrow left" @click="switcher('left')">
              <img src="~assets/images/png/arrow-l.png" alt="">
            </div>
            <div class="arrow right" @click="switcher('right')">
              <img src="~assets/images/png/arrow-r.png" alt="">
            </div>
          </div>
          <div class="description-wrapper">
            <ul>
              <li v-for="(item, index) of categories">
                {{ item.txt }}
              </li>
            </ul>
          </div>
        </div>
      </div>    
    </div>

    <div class="content-wrapper">
      <div class="container">

        <div class="content-filters__wrapper">
          <div  class="filter" 
                v-for="(item, index) of filters"
                :class="{'show': showFilter[index].filter}"
                >
            <div class="title-wrapper" @click="openFilter(item.id)">
              <span class="title">
                {{ item.desc }}
              </span>
            </div>
            <div class="options-wrapper">
              <ul>
                <li v-for="option of item.options">
                  {{ option.desc }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="content-categories__wrapper">
          <ul>
            <li v-for="(category, index) of getCategories()">
              <div class="item">
                <div class="img-wrapper">
                  <!--<img :src="'/_nuxt/client/assets/images/cards/' + category.img" alt="">-->
                  <img :src="'cards/' + category.img" alt="">
                </div>
                <div class="description-wrapper">
                  <div class="description-wrapper__top">
                    <div class="tags">
                      <router-link  class="tag" 
                                    v-for="item of category.tags"
                                    :to="{ name: item.url }"
                                    :key="item.title"
                      >                       
                        {{ item.title }}
                      </router-link>                      
                    </div>
                    <div class="title">
                      {{ category.title }}
                    </div>
                  </div>
                  <div class="description-wrapper__bottom">
                    <router-link :to="{ name: 'welcome' }" class="button"> 
                      УЗНАТЬ
                    </router-link>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>

      </div>    
    </div>  
    <div class="show-more__button" @click="getMore()">
      <img src="~assets/images/png/down.png" alt="">
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import LocaleDropdown from './LocaleDropdown'
import {sliderAdaptive} from './adaptive'

export default {
  components: {    
  },
  props: ['params'],
  data: () => ({
    imgSrc: '~assets/images/cards/',
    showMore: 0,
    showFilter: [
      { filter: false },
      { filter: false }
    ],
    categories: [ 
      { id:0, txt: 'Тесты по фильмам'}, 
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'},
      { id:1, txt: 'Тесты по гнигам'} 
    ],
    filters:[
      {
        id: 0,
        desc: 'категории',
        options: [
          { id: 0, desc: 'category1'},
          { id: 1, desc: 'category2'},
        ]
      },
      {
        id: 1,
        desc: 'популярное',
        options: [
          { id: 0, desc: 'популярное1'},
          { id: 1, desc: 'популярное2'},
        ]
      }
    ],
    categoriesList: []
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),
  created(){
    this.checkWidth();
  },
  methods: {
    switcher( arrow ){
      console.log(arrow);
    },
    checkWidth(){
      console.log(sliderAdaptive());      
    },
    openFilter( id ){
      console.log(' filter ', id);
      this.showFilter[id].filter = !this.showFilter[id].filter;
    },
    getCategories(){
      for (let i = 0; i < 6; i++){        
        this.categoriesList[i] = {            
          img: (i + 1) +'.png',
          url: '#',
          title: 'Какой ты покемон',
          tags: [
            { title: 'Хогвартс', url: 'welcome' },
            { title: 'Хогвартс1', url: 'welcome' },
            { title: 'Хогвартс2', url: 'welcome' },
          ]
        }
      }
      return this.categoriesList;
    },
    getMore(){
      this.showMore++;
      console.log('er');
      for (let i = 0; i < 3; i++){        
        this.categoriesList.push({            
          img: (i + 1) +'.png',
          url: '#',
          title: 'Какой ты покемон',
          tags: [
            { title: 'Хогвартс', url: 'welcome' },
            { title: 'Хогвартс1', url: 'welcome' },
            { title: 'Хогвартс2', url: 'welcome' },
          ]
        })
      }
      return this.categoriesList;
    }
  }
}
</script>

<style scoped>

</style>
