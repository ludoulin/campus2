<template>
   <div>
     <div class="container">
        <div class="row">
           <div class="col-lg-12 col-md-12">
                <div class="user-card">
                    <div class="user-card-body p-0">
                        <div class="user-edit-list">
                            <ul class="user-edit-profile d-flex nav nav-pills">
                                <li class="col-md-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="javascript::void(0)" @click='block=1' :class='{active:block==1}'>使用者基本資料</a>
                                </li> 
                                <li class="col-md-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="javascript::void(0)" @click='block=2' :class='{active:block==2}'>修改密碼</a>
                                </li> 
                                <li class="col-md-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="javascript::void(0)" @click='block=3' :class='{active:block==3}'>金流設定</a>
                                </li>   
                                <li class="col-md-3 p-0">
                                    <a class="nav-link" data-toggle="pill" href="javascript::void(0)" @click='block=4' :class='{active:block==4}'>設定可接受的付費方式</a>
                                </li>   
                            </ul>  
                        </div>
                    </div>
                </div>
            </div>

                <div class="col-lg-12 col-md-12">
                   <div class="user-edit-list-data">
                       <div class="tab-content">
                           <div class="tab-pane fade" id="personal-information" role="tabpanel" :class='{active:block==1}' v-if='block==1'>
                               <personal-information :personal="personal_data" @submit="submit_information"></personal-information>
                           </div>
                           <div class="tab-pane fade" id="change-password" role="tabpanel" :class='{active:block==2}' v-if='block==2'>
                                <change-password :errors="errors.password" @submit="submit_password"></change-password>
                           </div>
                           <div class="tab-pane fade " id="merge-account" role="tabpanel" :class='{active:block==3}' v-if='block==3'>
                                <personal-pay :errors="errors.linepay" @submit="submit_linepay"></personal-pay>
                           </div>
                           <div class="tab-pane fade" id="payment-type-select" role="tabpanel" :class='{active:block==4}' v-if='block==4'>
                               <payment-option :options="types" :payment_types="payment_types" :errors="errors.option" @submit="submit_option"></payment-option>
                           </div>
                       </div>
                   </div>
                </div> 
            </div>
       </div>
  </div>
</template>
<script>
import PaymentOption from './PaymentOption'
import ChangePassword from './ChangePassword'
import PersonalInformation from './PersonalInformation'
import PersonalPay from './PersonalPay'
 export default {
     components:{PaymentOption,ChangePassword,PersonalInformation,PersonalPay},
     props: {
            user: {
                type: Object,
                required: true,
            },

            payment_types: {
                type: Array,
                required: true
            },

            options:{
                type: Array,
            }
        },
    data(){
      return{
         block: 3,
         types:  [],
         errors: {
                    profile:{},
                    password:false,
                    linepay:false,
                    option:false
                 },
        personal_data: {},         

            }
    },
    mounted() {

            this.types = this.options;
            this.personal_data = this.user;

    },
    methods:{
        submit_information(obj){

        },
        submit_option(obj){
            
            axios.post("http://localhost/campus2/public/payment_option/edit",{id: this.user.id , option:obj.option , unchecked:obj.unchecked })
                    .then((response) => {
                         MessageObject.SuccessMessage("儲存成功");
                         this.types = response.data;
                    }).catch((error)=>{
                        if(error.response.status === 422){

                             if(error.response.data.message==="你還沒有設定LinePay帳號"){
                                 
                                 MessageObject.VaildSubmitMessage('儲存失敗',"你還沒有設定LinePay帳號");

                             }else{
                                this.errors.option = error.response.data.errors || {};
                                MessageObject.VaildSubmitMessage('儲存失敗','請一定要勾選一種付款方式');
                                console.log(this.errors.option);
                            }
                        }

                 });
            },
       submit_linepay(obj){

            axios.post("http://localhost/campus2/public/linepay/edit",{id: this.user.id , channelId:obj.channelId , channelSecret:obj.channelSecret })
                    .then((response) => {
                         MessageObject.SuccessMessage("儲存成功");
                    }).catch((error)=>{
                        if(error.response.status === 422){
                            this.errors.linepay = error.response.data.errors || {};
                            MessageObject.VaildSubmitMessage('儲存失敗', '請檢查錯誤訊息');
                        }else if(error.response.status === 404){
                            MessageObject.VaildSubmitMessage('儲存失敗', '找不到這個使用者');
                        }else if(error.response.status === 403){
                             MessageObject.VaildSubmitMessage('儲存失敗', '你沒有這個權限');
                        }else{
                            MessageObject.VaildSubmitMessage('儲存失敗', '內部錯誤');
                        }
                 });

       },     
       submit_password(obj){

           axios.post("http://localhost/campus2/public/users/change_password",{id: this.user.id , password:obj.password , new_password:obj.new_password, verify_password:obj.verify_password})
                    .then((response) => {
                         MessageObject.SuccessMessage("變更成功");
                    }).catch((error)=>{
                        if(error.response.status === 422){

                            if(error.response.data.message==="您的目前密碼輸入錯誤"){
                                 
                                 MessageObject.VaildSubmitMessage('儲存失敗',error.response.data.message );

                            }else{
                                 
                                  this.errors.password = error.response.data.errors || {};

                                  MessageObject.VaildSubmitMessage('儲存失敗', '請檢查錯誤訊息');

                                  console.log(this.errors.password);

                            }
                        }

                 });
       }
    }   
}
</script>



