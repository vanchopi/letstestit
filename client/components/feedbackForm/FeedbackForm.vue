<template>
  <div>
    <!--<button id="show-modal" @click="showModal = true">Show Modal</button>-->
    <pop-up v-if="showModal" @close="close()">
        <h3 slot="header">{{$t('contact_us')}}</h3>
        <div class="feedback-form" slot="body">
            <form @submit.prevent="submitForm()" v-if="sendedStatus != 'sended'">
                <div class="form-group custom__1">
                    <div class="form-row">
                        <label for="email" class="required">{{$t('email_address')}}</label>
                        <input type="email" 
                               class="form-control"
                               :class="{ 'form-group--error': $v.form.email.$error }" 
                               id="email" 
                               name="email" 
                               v-model="form.email"
                        >
                    </div>
                    <div class="form-row">
                        <label for="fio" class="required">{{$t('name')}}</label>
                        <input type="text" 
                               class="form-control"
                               :class="{ 'form-group--error': $v.form.name.$error }"
                               id="fio" 
                               name="fio" 
                               v-model="form.name"
                        >
                    </div>
                    <div class="form-row">
                        <label for="message" class="required">{{$t('message')}}</label>
                        <textarea name="message"
                                  class="form-control"
                                  :class="{ 'form-group--error': $v.form.message.$error }" 
                                  id="message" 
                                  rows="5" 
                                  v-model="form.message"
                        ></textarea>
                    </div>                                        
                </div>
            </form>
            <div class="message__wrapper" v-else>
                {{statusMessage}}
            </div>
        </div>
        <div class="form-submit__wrapper" slot="footer">
              <button class="base-button" @click="submitForm()" v-if="sendedStatus != 'sended'">
                {{$t('send')}}
              </button>
        </div>
    </pop-up>
  </div>
</template>

<script>

import { mapGetters, mapState, mapActions } from 'vuex'
import PopUp from '~/components/global/PopUp'
import {required, email, minLength} from "vuelidate/lib/validators";

export default {
  name: 'FeedbackForm',

  components: {
      PopUp,
  },

  props: ['showForm', 'onCloseForm'],
  data: () => ({    
    showModal: false,
    submitStatus: null,
    sendedStatus: null,
    statusMessage: '',
    form:{
      name: '',
      email: '',
      message: '',
    }
  }),
  validations: {
    form: {
      email: {
        required,
        email
      },
      name:{
        required,
        minLength: minLength(2)
      },
      message:{
        required,
        minLength: minLength(1)
      }
    }
  },
  computed:{
    ...mapState({
      //newCategoriesList: state => state.categories.categories, 
      sendStatus: state => state.form.status,     
    })
  },
  created(){
      this.showModal = this.showForm;
      console.log('status', this.sendStatus);
  },
  watch:{
      'showForm'(){
          this.showModal = this.showForm;    
      }
  },
  methods:{
    ...mapActions('form', ['sendFormData']), 
    submitForm() {
      console.log('submitForm');
      let self = this;      
      this.$v.$touch()
      if (this.$v.$invalid) {
        this.submitStatus = 'ERROR';
        console.log('ERROR');
      } else {
        this.submitStatus = 'PENDING'        
        this.sendFormData(this.form).then((response) => {
            console.log('sended - ', response.data.status);
            this.changeStatus(response.data.status);
        }).catch((error) => {
            console.log('from error - ',error);
            this.faildSending();            
        })
      }
    },
    changeStatus(status){        
        if(status == 'success'){
          this.sendedStatus = 'sended';
          this.statusMessage = 'сообщение отправлено!';
          this.submitStatus = 'OK';
          setTimeout(() => {           
            this.sendedStatus = null; 
            this.submitStatus = null;
            this.$v.$reset();
            this.cleanForm();
            this.close();
          }, 1000)
        }else{
          this.faildSending()
        }
    },
    faildSending(){
        this.sendedStatus = 'sended';
        this.statusMessage = 'Ой, что-то пошло не так 0_о...';
        setTimeout(() => {
          this.sendedStatus = null;
          this.submitStatus = null;
          this.statusMessage = '';
        }, 1000)
    },
    cleanForm(){
      this.form.name = '';
      this.form.email = '';
      this.form.message = '';
    },
    close(){
        //this.showModal = false;
        this.onCloseForm(false);
    }
  }
}
</script>

<style lang="scss">
    .feedback-form{
        .form-row{
          margin-top: 15px;
          &:first-child{
            margin-top: 0;
          }
        }
        textarea{
          width: 100%;
        }
    }
</style>
