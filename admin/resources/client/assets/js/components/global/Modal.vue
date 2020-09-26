<template>
  <div v-if="showModalLocal" @close="closeWindow">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  default header
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                  default body
                </slot>
              </div>

              <div class="modal-footer">
                <!--<slot name="footer">
                  default footer                  
                </slot>-->
                <div class="btn btn-primary btn-sm" @click="closeWindow">
                  Close
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>                                                                  
  </div>
</template>

<script>
export default {
    name: 'ModalWindow',
    props: ['showModal', 'onCloseWindow'],
    data() {
        return {
            // Code...
            showModalLocal: false,
        }
    },
    watch:{
      'showModal'(){
        this.showModalLocal = this.showModal;
      }
    },
    created() {
        // Code...
        console.log('opa - ', this.showModal);
    },
    methods: {
        //
        closeWindow(){
          this.showModalLocal = false;
          this.onCloseWindow(false);
        }
    }
}
</script>


<style scoped lang="scss">
  .modal-body{
    width: 100%;
    min-width: 512px;
  }
</style>