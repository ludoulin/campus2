<template>
    <div>
          <div class="user-card">
                     <div class="user-card-header d-flex justify-content-between">
                            <div class="card-header-title">
                                    <h4 class="card-title">使用者基本資料</h4>
                            </div>
                    </div>
                    <div class="user-card-body">
                            <form method="POST" @submit.prevent="VaildForm">
                                <div class="form-group row align-items-center">
                                    <div class="col-md-12">
                                        <div class="profile-img-edit">
                                            <img class="profile-picture" :src="personal.avatar" alt="profile-picture">
                                            <div class="personal-picture">
                                                <i class="fas fa-camera upload-button" @click.prevent="upload"></i>
                                                <input class="file-upload" type="file" accept="image/*" @change="source">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-6">
                                        <label for="fname">姓氏:</label>
                                        <input type="text" class="form-control" id="fname" v-model="fname">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="lname">名字:</label>
                                        <input type="text" class="form-control" id="lname" v-model="lname">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="uname">使用者名稱:</label>
                                        <input type="text" class="form-control" id="uname" v-model="personal.name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="d-block">性別:</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="gender_boy" name="gender" class="custom-control-input" value="男" v-model="gender">
                                            <label class="custom-control-label" for="gender_boy">男</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="gender_girl" name="gender" class="custom-control-input" value="女" v-model="gender">
                                            <label class="custom-control-label" for="gender_girl">女</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">信箱:</label>
                                        <input type="text" class="form-control" name="email" id="email" v-model="personal.email" disabled> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="phone">電話號碼:</label>
                                        <input type="text" class="form-control" name="phone" id="phone" v-model="phone"> 
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="introduction-field">個人賣場簡介</label>
                                        <textarea class="form-control" id="introduction-field" name="introduction" rows="5" style="line-height:22px;" v-model="personal.introduction"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary mr-2">儲存</button>
                                <button type="reset" class="btn btn-lg bg-danger">取消</button>
                         </form>
                    </div>
              </div>
         </div>
</template>
<script>
export default {
    props: {
            personal: {
                type: Object,
                required: true
            },

        },
    data(){
      return{
         fname:"",
         lname:"",
         phone:"",
         gender:[],
      }
    },
    methods:{
        VaildForm(){

            if(this.personal.name===""){

                MessageObject.VaildSubmitMessage('驗證錯誤','使用者名稱不能無填寫按下送出');

                return

            }else if(this.personal.email===""){

                MessageObject.VaildSubmitMessage('驗證錯誤','使用者信箱不能無填寫按下送出');

                return

            }else{

                return this.ConfirmInformation();

            }

            return

        },
        readURL(input){

            if (input.target.files && input.target.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-picture').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.target.files[0]);
            }
        },
        upload(){
             $(".file-upload").click();
        },
        source(input){
            this.readURL(input);
        },
        ConfirmInformation(){

            this.$emit('submit', { fname: this.fname , lname: this.lname, uname:this.personal.name ,avatar:this.personal.avatar ,gender:this.gender ,phone:this.phone, introduction:this.personal.introduction });

            return

        }
    },
}
</script>