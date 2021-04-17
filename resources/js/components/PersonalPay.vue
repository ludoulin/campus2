<template>
    <div>
          <div class="user-card">
                     <div class="user-card-header d-flex justify-content-between">
                            <div class="card-header-title">
                                    <h4 class="card-title">使用者金流</h4>
                            </div>
                    </div>
                    <div class="user-card-body">
                        <div class="alert alert-danger" v-if="this.errors!==false">
                            <div class="mt-2"><b>有錯誤發生：</b></div>
                                <ul class="mt-2 mb-2">
                                    <li v-for="(item,key) in errors" :key="key"><i class="glyphicon glyphicon-remove"></i> {{ key }}:{{ item.toString() }}</li>
                                </ul>
                            </div>
    
                            <form method="POST" @submit.prevent="LinePayForm">
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-6">
                                        <label for="channelId">LINE Pay-ChannelId:</label>
                                        <input type="text" class="form-control necessary" id="channelId" v-model="channelId" placeholder="限10位碼">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="channelSecret">LINE Pay-ChannelSecret:</label>
                                        <input type="text" class="form-control necessary" id="channelSecret" v-model="channelSecret" placeholder="限32位碼">
                                    </div>
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
    props:['errors'],
    data(){
      return{
         channelId:"",
         channelSecret:"",
      }
    },
    methods:{
        LinePayForm(){

        //    if(ValidateForm() && this.RegexIdCheck() && this.RegexSecretCheck()){

                return this.ConfirmLinePay()

        //    }

        },
        RegexIdCheck(){

            let regx = /^([0-9]{10})$/;

            if(!regx.test(this.channelId)){

            MessageObject.VaildSubmitMessage("驗證錯誤","ChannelId只能為10個數字");

            return false

            }

           return true  

        },
        RegexSecretCheck(){

            let regx = /^(?=.*[a-z])(?=.*\d)[a-z\d]{32}$/;

            if(!regx.test(this.channelSecret)){

            MessageObject.VaildSubmitMessage("驗證錯誤","channelSecret只能為32個英文及數字");

            return false

            }

           return true  

        },
        ConfirmLinePay(){

            this.$emit('submit', { channelId: this.channelId , channelSecret: this.channelSecret });

            this.reset();

        },
        reset(){

            if(this.channelId.trim().length == 0 || this.channelId.trim().length == 0){

                MessageObject.VaildSubmitMessage("驗證錯誤","已經全部清除了");
            
            }else{

                this.channelId = "";
            
                this.channelSecret = "" ;

            }

        },
    },
}
</script>