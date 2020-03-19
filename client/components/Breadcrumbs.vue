<template>
  <div class="breadcrumbs-wrapper">
    <div class="container">
      <ul>
        <li>
          <router-link :to="{ name: 'welcome' }"> 
            главная
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'catalog' }"> 
            тесты
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'welcome' }"> 
            тесты по фильмам
          </router-link>
        </li>
      </ul>  
    </div>  
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
//import LocaleDropdown from './LocaleDropdown'

export default {
  components: {    
  },

  data: () => ({
    
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    
  }
}
</script>

<style scoped>

</style>
