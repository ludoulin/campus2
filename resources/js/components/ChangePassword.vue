<template>
        <div>
              <div class="user-card">
                     <div class="user-card-header d-flex justify-content-between">
                            <div class="card-header-title">
                                    <h4 class="card-title">修改密碼</h4>
                            </div>
                    </div>
                    <div class="user-card-body">

                       <div class="alert alert-danger" v-if="this.errors!==false">
                            <div class="mt-2"><b>有錯誤發生：</b></div>
                                <ul class="mt-2 mb-2">
                                    <li v-for="(item,key) in errors" :key="key"><i class="glyphicon glyphicon-remove"></i> {{ key }}:{{ item.toString() }}</li>
                                </ul>
                            </div>

                            <form method="POST" @submit.prevent="VaildForm">
                                <div class="form-group">
                                    <label for="current_pass">目前密碼 :</label>
                                    <input class="form-control" :class="{'is-invalid':ValidCheck.password===false,'is-valid':ValidCheck.password===true}" type="Password" name="password" id="current_pass" v-model="password">
                                    <div class="text-danger" v-if="ValidCheck.password===false">密碼長度需為8-12個字母,並且包含小寫字母和數字</div>
                                    <div class="text-success" v-if="ValidCheck.password===true">符合條件</div>
                                </div>
                                <div class="form-group">
                                    <label for="new_pass">新密碼 :</label>
                                    <input class="form-control" :class="{'is-invalid':npass_invaild,'is-valid':npass_vaild}" type="Password" name="new_password" id="new_pass" v-model="new_password">
                                    <div class="text-danger" v-if="ValidCheck.new_password===false">密碼長度需為8-12個字母,並且包含小寫字母和數字</div>
                                    <div class="text-danger" v-if="checked===true">新密碼不能和原密碼相同</div>
                                    <div class="text-success" v-if="npass_vaild">符合條件</div>
                                </div>
                                <div class="form-group">
                                    <label for="verify_pass">再次確認新密碼 :</label>
                                    <input class="form-control" :class="{'is-invalid':vpass_invaild,'is-valid':vpass_vaild}" type="Password" name="verify_password" id="verify_pass" v-model="verify_password">
                                    <div class="text-danger" v-if="ValidCheck.verify_password===false">密碼長度需為8-12個字母,並且包含小寫字母和數字</div>
                                    <div class="text-danger" v-if="two_checked===true">和新密碼不相同</div>
                                    <div class="text-danger" v-if="three_checked===true">新密碼不能和原密碼相同</div>
                                    <div class="text-success" v-if="vpass_vaild">符合條件</div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary mr-2">儲存</button>
                                <button type="reset" class="btn btn-lg bg-danger" @click.prevent="reset">取消</button>
                         </form>
                    </div>
              </div>
         </div>
</template>
<script>
export default {
    props: ['errors'],
    data(){
      return{
         password: "",
         new_password:"",
         verify_password:"",
         ValidCheck:{
             password: null,
             new_password: null,
             verify_password:null,
         }
      }
    },
    watch:{
          password(after,before){

                if(after.length!=0){
                 this.ValidCheck.password = /^(?=.*[a-z])(?=.*\d)[a-z\d]{8,12}$/.test(after);
                }
                 return
          },
          new_password(after,before){

                if(after.length!=0){
                 this.ValidCheck.new_password = /^(?=.*[a-z])(?=.*\d)[a-z\d]{8,12}$/.test(after);
                }
                 return;
          },
          verify_password(after,before){

                if(after.length!=0){
                 this.ValidCheck.verify_password = /^(?=.*[a-z])(?=.*\d)[a-z\d]{8,12}$/.test(after);
                }
                 return;
          },
        },
    computed:{
        checked(){
            if(this.new_password!==""&& this.password!==""){

             return this.new_password === this.password ? true : false

            }

            return false
        },
        npass_invaild(){

            return this.ValidCheck.new_password===false||this.checked===true;
        },
        npass_vaild(){

            return this.ValidCheck.new_password===true&&this.checked!==true;
        },
        vpass_invaild(){

            return this.ValidCheck.verify_password===false||this.two_checked===true||this.three_checked;
        },
        vpass_vaild(){

            return this.ValidCheck.verify_password===true&&this.two_checked!==true&&this.three_checked!==true;
        },

        two_checked(){

            if(this.verify_password!==""&& this.new_password!==""){

             return this.verify_password !== this.new_password ? true : false

            }

            return false

        },
        three_checked(){

            if(this.verify_password!==""&& this.password!==""){

             return this.verify_password === this.password ? true : false

            }

            return false

        }
    },
    methods:{

        ConfirmPassword(){

                 this.$emit('submit', { password: this.password , new_password: this.new_password, verify_password: this.verify_password });

                 this.reset();

                 return

 
        },

        reset(){

            this.password = "";
            
            this.new_password = "" ;

            this.verify_password= "";

            this.ValidCheck.password = null;

            this.ValidCheck.new_password = null;

            this.ValidCheck.verify_password = null;

            return

        },
        VaildForm(){

            if(this.password.length===0||this.new_password.length===0||this.verify_password.length===0){

                    MessageObject.VaildSubmitMessage('驗證錯誤','各密碼欄位不能無填寫按下送出');

                return

            }else if(this.ValidCheck.password===false||this.ValidCheck.new_password===false||this.ValidCheck.verify_password===false){

                MessageObject.VaildSubmitMessage('驗證錯誤','密碼欄位不能在不符合規則下按下送出');

                return

            }else if(this.checked===true||this.three_checked===true){
                
                MessageObject.VaildSubmitMessage('驗證錯誤','舊密碼和新密碼不能相同');

                return

            }else if(this.two_checked===true){

                MessageObject.VaildSubmitMessage('驗證錯誤','確認密碼和新密碼一定要相同');

                return

            }else if(this.ValidCheck.password===true&&this.npass_vaild===true&&this.vpass_vaild===true){

                   return this.ConfirmPassword();

                
            } 
        }
    },
}
</script>