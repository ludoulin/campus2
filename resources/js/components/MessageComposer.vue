<template>
    <div class="p-3 chat-input-section">
        <div class="row">
            <div class="col">
                <div class="position-relative">
                    <input type="text" class="form-control chat-input rounded"  v-model="message" placeholder="請輸入訊息....">            
                </div>
            </div>
            <div class="col-auto">
                <button @click="send" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="fas fa-share"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            };
        },
        methods: {
            send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                     MessageObject.VaildSubmitMessage('留言驗證錯誤','請勿無填寫內容或是少於兩字下按下送出喔');
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>