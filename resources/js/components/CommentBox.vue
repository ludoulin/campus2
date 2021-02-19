<template>
    <div>
  <div class="reply-box">
    <div class="form-group">
      <textarea class="form-control" v-model="message" rows="3" placeholder="請在此輸入您的提問，賣家將會回覆您的提問~"></textarea>
    </div>
    <button @click="send" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i>確認送出</button>
</div>
    </div>
</template>
<script>
  export default {
    props:['_productid'],
    data(){
      return{
        product_id:this._productid,
        message:'',
      }
    },
    methods:{
        send(e) {
                e.preventDefault();
                if (this.message == '') {
                   swal.fire({
                    title: '留言驗證錯誤',
                    icon: 'error',
                    confirmButtonText: '知道了嗎？',
                    allowOutsideClick: false,
                    text: '請勿無填寫內容或是少於兩字下按下送出喔',
                 });
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
    }
}
</script>