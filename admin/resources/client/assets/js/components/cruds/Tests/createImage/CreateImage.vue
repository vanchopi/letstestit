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
            <canvas width="512" height="228" id="canvas1" style='position: relative; left:0px; top:0px; display: none;'></canvas>
            <canvas width="512" height="228" id="canvas2" style='position: relative; left:0px; top:0px; display: none;'></canvas>
            <img id="resultImg" src="" alt="">
            <div class="btn-wrp">
              <a class="btn btn-primary btn-sm" href="#" @click.prevent="generateImg">Generate image</a>
              <a class="btn btn-success btn-sm" href="#" @click.prevent="applyImage">Apply image</a>
            </div>
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
            // Code...
            showModalLocal: false,
            imgText:{
              title: '',
              result: '',
              description: '',
            }
        }
    },
    watch:{
      'showModal'(){
        this.showModalLocal = this.showModal;
        this.fillData();
      }
    },
    created() {
        // Code...
        console.log('results - ', this.results);        
    },
    methods: {
        //
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
            var canvas = document.getElementById("canvas1"),
                canvas2 = document.getElementById("canvas2"),                
                img = document.getElementById("thumb"),
                resultImg = document.getElementById("resultImg"),
                options = {
                    offsetX: 0,
                    offsetY: 0,
                    width: 512,
                    height: 228,
                };
          //console.log('custom img - ', img);
            rasterizeHTML.drawHTML(
                '<div style="width: 512px; height: 228px; padding: 15px; background-image: url('+ img.src +'); background-size: cover;">' +
                '<div class="title-wrp" style="display: flex; align-items: center; justify-content: flex-start; padding-bottom: 15px; margin-bottom: 15px; width: calc(100% - 40px); border-bottom: 1px solid white;">'+ 
                '<img width="70" src="/logo.png" style="margin-right: 0px;">' + 
                '<b style="position: absolute; margin-left: 80px;">' +
                '<span style="color: white;">'+ this.imgText.title +'</span>'+
                '</b>'+
                '</div>'+
                '<span style="color: white; font-size: 22px; font-weight: bold; margin-bottom: 5px; display: block; font-family: Open Sans,sans-serif;">Мой результат : ' + this.imgText.result + '</span>'+
                '<span style="color: white; font-size: 12px; font-weight: normal; margin-bottom: 15px; display: block; font-family: Open Sans,sans-serif;">' + this.imgText.description + '</span>'+
                '</div>', 
                canvas).then(function(renderResult){
                let contextCanvas2 = canvas2.getContext('2d');                                   
                var img2 = new Image;
                img2.onload = function() {
                    contextCanvas2.drawImage(img2, -10, -10, 522, 238);
                    resultImg.src = canvas2.toDataURL('image/png');
                };
                img2.src = canvas.toDataURL('image/png');
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