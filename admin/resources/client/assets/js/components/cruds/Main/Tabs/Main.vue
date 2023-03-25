<template>
  <form @submit.prevent="submitForm">
    <div class="form-group">
      <label for="banner">Баннер</label>
      <select class="form-control" id="banner">
        <option selected>Выберите...</option>
        <option 
          v-for="affilate in affilates"
          :value="affilate.id"
          >
          {{affilate.description}}
        </option>
      </select>
    </div>
  </form>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: "Main",
  components: {    
  },
  props: {    
  },
  computed: {   
    affilates(){
      return this.$store.state.Affilates.affilates;
    } 
  },
  data(){
    return {
      result: null,
      showModal: false,   
      banner: null,   
    }
  },
  created(){
    this.getAffilates();
  },
  methods: {
    ...mapActions('Affilates', ['get']),
    getAffilates(){
      this.get();
    },  
    submitForm(){
      console.log('submitForm');
    }
  }
};
</script>