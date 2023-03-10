<template>
  <div>
    <AddAffilate 
      :showModal="showModal"
      :onCloseWindow="onCloseWindow"
    /> 
    <a class="btn btn-primary btn-sm" href="#" @click.prevent="showModal = true">Добавить партнерскую программу</a>
  </div>
</template>

<script>
import AddAffilate from '../Modals/AddAffilate.vue';
export default {
  name: "Affilates",
  components: {
    AddAffilate,
  },
  props: {    
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
  methods: {
    onCloseWindow(){
      this.showModal = false;
    },
  }
};
</script>