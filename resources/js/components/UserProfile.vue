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
                                    <a class="nav-link" data-toggle="pill" href="javascript::void(0)" @click='block=3' :class='{active:block==3}'>合併帳號</a>
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
                               <!-- <div class="card">
                                    <div class="card-header">
                                        <h4><i class="glyphicon glyphicon-edit"></i> 編輯個人資料</h4>
                                    </div>
                                    <div class="card-body">

                                        <form action="" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="name-field">使用者名稱</label>
                                                <input class="form-control" type="text" name="name" id="name-field" v-model="user.name" />
                                            </div>
                                            <div class="form-group">
                                                <label for="email-field">信箱</label>
                                                <input class="form-control" type="text" name="email" id="email-field" v-model="user.email" />
                                            </div>
                                            <div class="form-group">
                                                <label for="introduction-field">個人賣場簡介</label>
                                                <textarea name="introduction" id="introduction-field" class="form-control" rows="3" v-model="user.introduction"></textarea>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="avatar" class="avatar-label">大頭貼</label>
                                                <input type="file" name="avatar" class="form-control-file">
                            
                                                <br>
                                                <img class="thumbnail img-responsive" :src="user.avatar" width="200" />
                                            </div>
                                            <div class="well well-sm">
                                                <button type="submit" class="btn btn-primary">儲存</button>
                                            </div>
                                        </form>
                                    </div>
                                </div> -->
                           </div>
                           <div class="tab-pane fade" id="change-password" role="tabpanel" :class='{active:block==2}' v-if='block==2'>
                                <change-password :errors="errors.password" @submit="submit_password"></change-password>
                           </div>
                           <div class="tab-pane fade " id="merge-account" role="tabpanel" :class='{active:block==3}' v-if='block==3'>
                                 {{errors.option}}
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
 export default {
     components:{PaymentOption,ChangePassword,PersonalInformation},
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
         block:1,
         types:  [],
         errors: {
                    profile:{},
                    password:{},
                    merge:{},
                    option:{}
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
                            this.errors.option = error.response.data.errors || {};
                            MessageObject.VaildSubmitMessage('儲存失敗','請一定要勾選一種付款方式');
                            console.log(this.errors.option);
                        }

                 });
            },
       submit_password(obj){

           axios.post("http://localhost/campus2/public/users/change_password",{id: this.user.id , password:obj.password , new_password:obj.new_password, verify_password:obj.verify_password})
                    .then((response) => {
                         MessageObject.SuccessMessage("變更成功");
                    }).catch((error)=>{
                        if(error.response.status === 422){

                            if(error.response.data.message){
                                 
                                 MessageObject.VaildSubmitMessage('儲存失敗',error.response.data.message);

                            }else{
                                 
                                  this.errors.password = error.response.data.errors || {};

                                  MessageObject.VaildSubmitMessage('儲存失敗', this.errors.password);

                                  console.log(this.errors.password);

                            }
                        }

                 });
       }
    }   
}
</script>



