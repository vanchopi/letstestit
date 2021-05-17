<template>
  <div>
    <!--<button id="show-modal" @click="showModal = true">Show Modal</button>-->
    <pop-up v-if="showModal" @close="close()">
        <h3 slot="header">{{$t('contact_us')}}</h3>
        <div class="feedback-form" slot="body">
            <form @submit.prevent="sendForm">
                <div class="form-group custom__1">
                    <div class="form-row">
                        <label for="email" class="required">{{$t('email_address')}}</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-row">
                        <label for="fio" class="required">{{$t('name')}}</label>
                        <input type="text" class="form-control" id="fio" name="fio">
                    </div>
                    <div class="form-row">
                        <label for="message" class="required">{{$t('message')}}</label>
                        <textarea name="message" id="message" rows="5"></textarea>
                    </div>                                        
                </div>
            </form>
        </div>
        <div class="form-submit__wrapper" slot="footer">
              <button class="base-button" @click="close()">
                Send
              </button>
        </div>
    </pop-up>
  </div>
</template>

<script>

import PopUp from '~/components/global/PopUp'
export default {
  name: 'FeedbackForm',

  components: {
      PopUp,
  },

  props: ['showForm', 'onCloseForm'],
  data: () => ({    
    showModal: false,
  }),
  created(){
      this.showModal = this.showForm;      
  },
  watch:{
      'showForm'(){
          this.showModal = this.showForm;    
      }
  },
  methods:{
    sendForm(){
      console.log();
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
