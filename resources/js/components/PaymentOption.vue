<template>
    <div>
              <div class="user-card">
                     <div class="user-card-header d-flex justify-content-between">
                            <div class="card-header-title">
                                    <h4 class="card-title">可接受的付款方式</h4>
                            </div>
                    </div>
                    <div class="user-card-body">
                        <div class="alert alert-danger" v-if="this.errors!==false">
                            <div class="mt-2"><b>有錯誤發生：</b></div>
                                <ul class="mt-2 mb-2">
                                    <li v-for="(item,key) in errors" :key="key"><i class="glyphicon glyphicon-remove"></i> {{ key }}:{{ item.toString() }}</li>
                                </ul>
                            </div>
                            <form method="POST" @submit.prevent="SelectPayment">
                                <div class="form-group row align-items-center" v-for="payment_type in payment_types" :key="payment_type.id">
                                    <label class="col-8 col-md-3" :for="`payment_type${payment_type.id}`">{{ payment_type.name }} :</label>
                                        <div class="col-4 col-md-9">
                                             <label class="switch">
                                                    <input type="checkbox" name=options :id="`payment_type${payment_type.id}`" :value="payment_type.id" v-model="option">
                                                    <span class="slider"></span>
                                            </label>
                                        </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary mr-2">儲存</button>
                                <button type="reset" class="btn btn-lg bg-danger" @click.prevent="reseted">取消</button>
                         </form>
                    </div>
              </div>
         </div>
</template>
<script>
export default {
    props: {
            
            payment_types: {
                type: Array,
                required: true
            },

            options:{
                type: Array,
            },

            errors:{
                required:false,
            },
        },
    data(){
      return{
         option: [],
         reset:[],
      }
    },
    computed:{
        error(){
            return this.errors
        }
    },

    mounted() {

        this.OptionCheck(this.option);
        this.reset = this.option;

    },
    watch:{
          option(after,before){
            if(after.length==0){
                 MessageObject.checkMessage('警告','請一定要勾選可接受的付款方式',this.reseted);
                 return
            }
            return;
          }
        },
    methods:{
        SelectPayment(){

            const unchecked = [];

            $("input:checkbox[name=options]:not(:checked)").each(function(){
                unchecked.push($(this).val());
            });


            if(this.option.length===0){

                MessageObject.VaildSubmitMessage('驗證錯誤','請一定要勾選可接受的付款方式');

                return false

            }else{

            return  this.$emit('submit', { option:this.option , unchecked });
 
            }
            
        },
        OptionCheck(option){
            this.options.forEach(function(item){
                 option.push(item.id);
            });
        },

        reseted(){

             this.option = this.reset;
        }
    },
}
</script>