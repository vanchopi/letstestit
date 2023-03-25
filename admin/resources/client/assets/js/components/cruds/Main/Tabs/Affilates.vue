<template>
  <div>
    <div class="list-wrapper">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Ссылка</th>
            <th scope="col">Тип</th>
            <th scope="col">Картинка</th>
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="affilate in affilates">
            <td>{{affilate.id}}</td>
            <td>{{affilate.link}}</td>
            <td>{{affilate.type}}</td>
            <td v-html="affilate.affilate_image_link"></td>
            <td>
              <div>
                <button type="button" class="btn btn-primary" @click="onEdit(affilate.id)">Edit</button>
                <button type="button" class="btn btn-danger" @click="onDelete(affilate.id)">Delete</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <hr />
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
    },
    onEdit(id){
      console.log('onEdit');
    },
    onDelete(id){
      let text = "Вы уверены, что хотите удалить программу?";
      if (confirm(text) == true) {
        console.log('onDelete');
      } else {
        return false
      }      
    }
  }
};
</script>