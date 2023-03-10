<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
        <h1>Общие настройки</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <form @submit.prevent="submitForm" novalidate>
            <div class="bt-wrapper">
              <back-buttton></back-buttton>                        
            </div>
            <bootstrap-alert />

            <ul class="nav nav-tabs"
              >
              <li class="nav-item active">
                  <a class="nav-link" data-toggle="tab" href="#affilates">Партнерки</a>
              </li>                                          
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="affilates">
                <div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Списки</h3>
                  </div>
                  <div class="box-body">
                    <Affilates />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import Affilates from "./Tabs/Affilates.vue"
export default {
  name: "MainPage",
  components: {
    Affilates,
  },
  props: {    
  },
  data(){
    return {
      
    }
  },
  methods: {
    submitForm(){
      return;
    }
  }
};
</script>
