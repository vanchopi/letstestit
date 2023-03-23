<template>
  <div>
    <div class="list-wrapper">
      <div v-for="affilate in affilates">
        {{affilate}}
        <hr />
      </div>
    </div>
    <AddAffilate 
      :showModal="showModal"
      :onCloseWindow="onCloseWindow"
      :onUpdate="getAffilates"
    /> 
    <a class="btn btn-primary btn-sm" href="#" @click.prevent="showModal = true">Добавить партнерскую программу</a>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import AddAffilate from '../Modals/AddAffilate.vue';
export default {
  name: "Affilates",
  components: {
    AddAffilate,
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
      advertisment: [
        {
          link: null,
          img: null,
        }
      ]
    }
  },
  created(){
    this.getAffilates();
  },
  methods: {
    ...mapActions('Affilates', ['get']),
    onCloseWindow(){
      this.showModal = false;
    },
    getAffilates(){
      this.get();
    }
  }
};
</script>