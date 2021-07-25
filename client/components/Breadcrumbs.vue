<template>
  <div class="breadcrumbs-wrapper">
    <div class="container">
      <ul>
        <li>
          <router-link :to="{ name: 'welcome' }"> 
            главная
          </router-link>
        </li>        
        <li v-for="(crumb, index, name) in crumbs">
            <!--{{ name }} : {{ crumb }}-->
            <router-link :to="{ name: crumb.name, params: crumb.params }"
                          v-if="index != crumbs.length - 1"
              >
              {{crumb.title}}
            </router-link>
            <span v-else>
              {{crumb.title}}
            </span>
        </li>

      </ul>  
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'

export default {
  components: {    
  },

  data: () => ({
    
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',

    }),
    ...mapState({
      categoriesList: state => state.categories.categories,
      testTitle: state => state.test.test,
      langs: state => state.lang.locales,
      language: state => state.lang.locale,
    }),
    crumbs() {
        let langKeys = Object.keys(this.langs);
        const fullPath = this.$route.fullPath;
        let links = Array.from( fullPath.split('/')),
            crumbs = [],
            path = '';
        if (links.length > 0 && links[0] == "") {
          links.shift();
        };
        if (langKeys.includes(this.language)) {
          links = links.slice(1);
        };
        links.forEach((link, index) => {
              if (path == ''){path = this.language}
              path = `${path}/${link}`
              console.log('path - ', path);
              let match = this.$router.match(path),
                  title = '';          
              if (match.name !== null) {

                if(match.name == 'category'){
                  let title = this.categoriesList.filter( category => category.url == link);
                  console.log('title', title[0].title);
                }

                switch(match.name){
                  
                  case 'catalog':
                    title = this.$t('catalog');      
                    break;
                  case 'category':
                    let subTitle = this.categoriesList.filter( category => category.url == link);
                    title = subTitle.length ? subTitle[0].title : link;
                    break;
                  case 'test':
                    title = this.testTitle != null ? this.testTitle : match.path.split('/').pop();
                    break;
                  case 'search':
                    title = this.$t('search');
                    break;
                  case 'about':
                    title = this.$t('about');
                    break;
                  default:
                        
                    break;
                }

                //console.log(index ,'!.. match ', match, link);
                crumbs.push({
                  name: match.name,
                  path: match.path,
                  params: match.params,
                  title: title.toLowerCase(),
                  query: match.query,
                })
            }          
        })
        console.log('1. crumbs - ', crumbs);
        /*console.log('1. crumbs - ', crumbs);
        console.log('2. path - ', this.$router.match(fullPath.split('/128')[0]));
        console.log('3. categoriesList - ', this.categoriesList);*/

        return crumbs;
    }    
  },

  methods: {
    test(){
        const fullPath = this.$route.fullPath;
        console.log('fullPath - ', fullPath);
    }
  }
}
</script>

<style scoped>

</style>
