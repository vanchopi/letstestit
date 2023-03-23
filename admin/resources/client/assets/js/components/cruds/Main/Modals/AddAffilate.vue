<template>
    <modal-window :showModal="showModal" :onCloseWindow="onCloseWindow">
      <span slot="header">Добавить партнерскую программу</span>
      <div slot="body">
        <form @submit.prevent="submitForm">
          <div v-for="(value, field) in affilate" class="form-group">
              <label for="results">{{labelList[field] ? labelList[field] : field}}:</label>
              <input 
                v-if="inputFields.find((item) => item === field)"  
                type="text" 
                class="form-control" 
                v-model:value="affilate[field]"
              >
              <!-- <text-editor
                v-else-if="descriptionFields.find((item) => item === field)" 
                :placeholder="field"  
                v-model="affilate[field]"
                :textCallbak="textEditorOnInput"
                :windowHeight="100"
                :num="field"
              /> -->
              <textarea
                v-else-if="descriptionFields.find((item) => item === field)" 
                class="form-control"
                cols="60" 
                rows="5" 
                v-model="affilate[field]"
              />
              <v-select
                v-else-if="dropDownFields.find((item) => item === field)" 
                class="form-control"
                :label="field"
                v-model:value="affilate[field]"
                :options="getSource(field)"
              />
              <div v-else-if="fileField.find((item) => item === field)" :key="imgCounter">
                <input                   
                  type="file"
                  @change="setImage"
                  class="form-control"
                />
                <button class="btn btn-xs btn-danger"
                  type="button"
                  @click="deleteImage"
                  >
                  Remove file
                </button>
              </div> 
          </div>
        </form>
      </div>
      <div slot="footer" class="">
        <a class="btn btn-primary btn-sm" href="#" @click.prevent="addAffilate">Добавить</a>
      </div>
    </modal-window>
</template>

<script>
import { mapActions } from 'vuex'
import ModalWindow from '../../../global/Modal';
import TextEditor from '../../../global/TextEditor';
export default {
  name: "AddAffilates",
  components: {
    ModalWindow,
    TextEditor,
  },
  props: {  
    showModal: {
      type: Boolean,
      required: true,
      default: false,
    },
    onCloseWindow: {
      type: Function,
      default: () => {},
      required: true,
    } 
  },
  data(){
    return {
      result: null,
      imgCounter: 0,
      affilate: {
        link: null,
        affilate_image: null,
        type: null,
        description: "",
      },
      labelList: {
        link: "ссылка",
        affilate_image: "картинка",
        type: "тип",
        description: "описание",
      },
      types: ["banner", "context", "общий"],
      inputFields: ["link"],
      fileField: ["affilate_image"],
      dropDownFields: ["type"],
      descriptionFields: ["description"],
    }
  },
  methods: {
    ...mapActions('Affilates', ['sendForm']),
    addAffilate(){
      this.sendForm(this.affilate);
    },
    setImage(e){
      this.affilate[this.fileField] = e.target.files[0];
    },
    deleteImage(){
      this.affilate[this.fileField] = null;
      this.imgCounter++;
    },
    textEditorOnInput(data){
      //console.log(data);
    },
    getSource(field){
      if(field === 'type'){
        return this.types;
      }
    }
  }
};
</script>