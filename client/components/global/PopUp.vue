<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-close" @click="$emit('close')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                        </svg>
                    </div>
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
                        <slot name="footer">
                            default footer
                            <button class="modal-default-button" @click="$emit('close')">
                              OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
  name: 'PopUp',

  props: {},
  data: () => ({    
    
  }),
  created(){
      
  },
  watch:{
      /*'loader'(){
        this.ploader = this.loader;
      }*/
  },
}
</script>

<style lang="scss">
  @import '~assets/sass/_variables.scss';
  .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  position: relative;
  max-width: 500px;
  width: calc(100% - 50px);
  margin: 0px auto;
  padding: 20px 30px;
  background-color: $card-test-title;
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: $font-main;
  .modal-close{
    position: absolute;
    top: -40px;
    right: -40px;
    cursor: pointer;
    border-radius: 50%;
    background-color: $card-test-title;
    border: 1px solid $card-test-title;
    svg{
      width: 35px;
      height: 35px;
      path{
        transition: fill .3s ease;
        fill: $main-color;        
      }
      &:hover{
        path{
          fill: $main-fill-color;
        }
      }
    }
  }
}

.modal-header h3 {
  margin-top: 0;
  color: $main-color;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
.modal-footer > * {
  margin: 0;
}
.modal-footer{
  border: none;
  margin: 0;
}
.form-control{
  padding: 5px 20px;
  border-radius: 5px;
  border: $main-border;  
}
textarea{
  resize: none;
  padding: 5px 20px;
  border-radius: 5px;
  border: $main-border;
}
.form-submit__wrapper{
    width: 120px;
    .base-button{
        background-color: $main-color;
        border-color: $main-color;
        &:hover{
          background-color: $card-test-title;
          border-color: $main-fill-color;
        }
    }
}
</style>
