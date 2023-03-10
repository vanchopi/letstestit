<template>  
      <modal-window :showModal="showModal" :onCloseWindow="onCloseWindow">                                                                
          <span slot="header">Create Result Image</span>
          <div slot="body">
            <span>{{title}}</span>
            <input  type="file"
                    class="form-control"
                    @change="uploadImg($event)"
            >
            <ul class="list-unstyled">
                <li>                    
                    <button class="btn btn-xs btn-danger"
                            type="button"
                            @click="removeImage"
                    >
                        Remove file
                    </button>
                </li>
            </ul>
            <hr>
                <div class="wrp">                                        
                    <div class="form-group">                    
                        <input type="text" 
                           class="form-control" 
                           placeholder="Title" 
                           name="img_title"                       
                           required=""
                           v-model="imgText.title"                        
                        >
                    </div>
                    <div class="form-group">                    
                        <input type="text" 
                           class="form-control" 
                           placeholder="result" 
                           name="img_result"                       
                           required=""
                           v-model="imgText.result"                        
                        >
                    </div>
                    <div class="form-group">                    
                        <input type="text" 
                           class="form-control" 
                           placeholder="description" 
                           name="img_description"                       
                           required=""
                           v-model="imgText.description"                        
                        >
                    </div>
                </div>
            <hr>
            <div class="img-wrp">                                                            
                <img src="" alt="" id="thumb">
            </div>              
            <canvas :width="wd" :height="ht" id="canvas1" style='position: relative; left:0px; top:0px; display: none;'></canvas>
            <canvas :width="wd" :height="ht" id="canvas2" style='position: relative; left:0px; top:0px; display: none;'></canvas>
            <img id="resultImg" src="" alt="">
          </div>
          <div slot="footer" class="">
            <a class="btn btn-primary btn-sm" href="#" @click.prevent="generateImg">Generate image</a>
            <a class="btn btn-success btn-sm" href="#" @click.prevent="applyImage">Apply image</a>
          </div>
      </modal-window>  
</template>

<script>
import ModalWindow from '../../../global/Modal'
import * as rasterizeHTML from 'rasterizehtml';
export default {
    components:{
      ModalWindow
    },
    name: 'CreateImage',
    props: ['showModal', 'onCloseWindow', 'title', 'num', 'results', 'onApplyImage'],
    data() {
        return {
            showModalLocal: false,
            imgText:{
              title: '',
              result: '',
              description: '',
            },
            wd: 1024,
            ht: 456,
        }
    },
    watch:{
      'showModal'(){
        this.showModalLocal = this.showModal;
        this.fillData();
      }
    },
    methods: {
        fillData(){
          this.imgText = {
            title : this.title,
            result: this.results.result,
            description: this.results.description,
          }
        },
        closeWindow(){
          this.showModalLocal = false;
          this.onCloseWindow(false);
        },
        removeImage(){

        },
        uploadImg( e ){
            var reader  = new FileReader(),
                context = this,
                file = e.target.files[0],
                id = 'thumb';                      
            reader.onloadend = (function(f, context) {
                return function(e) {                    
                    let el = document.getElementById(id);                        
                    el.src = this.result;                    
                };                
            })(file);

            if (file) {
                reader.readAsDataURL(file);
            } else {
                console.log('Ooops');
            }
        },
        imgTemplate(){

        },
        generateImg(){            
            var self = this,
                canvas = document.getElementById("canvas1"),
                canvas2 = document.getElementById("canvas2"),                
                img = document.getElementById("thumb"),
                resultImg = document.getElementById("resultImg"),
                wd = this.wd,
                ht = this.ht,
                options = {
                    offsetX: 0,
                    offsetY: 0,
                    width: this.wd,
                    height: this.ht,
                };
            rasterizeHTML.drawHTML(
                '<div style="width: calc('+ wd + 'px - 60px); height: calc('+ ht + 'px - 60px); padding: 30px; background-image: url('+ img.src +'); background-size: cover; text-shadow: 2px 2px 1px #000;">' +
                '<div class="title-wrp" style="display: flex; align-items: center; justify-content: flex-start; padding-bottom: 30px; margin-bottom: 30px; width: calc(100%); border-bottom: 1px solid white;">'+ 
                '<img width="140" src="/logo.png" style="margin-right: 0px;">' + 
                '<b style="position: relative; margin-left: 20px; font-size: 28px; margin-top: 4px">' +
                '<span style="color: white;">'+ this.imgText.title +'</span>'+
                '</b>'+
                '</div>'+
                '<span style="color: white; font-size: 34px; font-weight: bold; margin-bottom: 15px; display: block; font-family: Open Sans,sans-serif;">Мой результат : ' + this.imgText.result + '</span>'+
                '<span style="color: white; font-size: 28px; font-weight: normal; margin-bottom: 25px; display: block; font-family: Open Sans,sans-serif;">' + this.imgText.description + '</span>'+
                '<style>'+
                'body{\
                    margin: 0;\
                    padding: 0;\
                }\
                svg body{\
                    width: ' + this.wd + 'px;\
                    height: ' + this.ht + 'px;\
                    position: relative;\
                }\
                </style>'+
                '</div>', 
                canvas,{
                  width: this.wd + 50,
                  height: this.ht + 50,
                }
                ).then(function(renderResult){
                console.log('renderResult - ', renderResult);
                let contextCanvas2 = canvas2.getContext('2d');                                   
                var img2 = new Image;
                img2.src = canvas.toDataURL('image/png');
                img2.onload = function() {
                    //contextCanvas2.drawImage(img2, -10, -10, wd + 10, ht + 10); // width > 1000px
                    contextCanvas2.drawImage(
                      renderResult.image,
                      0, 
                      0, 
                      self.wd, // cuted
                      self.ht, 
                      0,
                      0, 
                      self.wd, //inserted
                      self.ht
                    );
                    resultImg.src = canvas2.toDataURL('image/jpeg', 0.8);                    
                };                
            })
        },
        applyImage(){
            let data = {
                src: document.getElementById("resultImg").src,
                num: this.num,
            }
            this.onApplyImage(data);
        },
    }
}
</script>


<style scoped lang="scss">
  .img-wrp{
    width: 150px;
    display: none;
    img{
      width: 100%;
    }
  }
  #resultImg{
    width: 100%;
    max-width: 512px;
  }
  .btn-wrp{
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
      a{
        &:last-child{
        margin-left: 10px;
      }
    }
  }
</style>