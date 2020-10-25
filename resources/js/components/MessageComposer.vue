<template>
    <div class="composer">
        <textarea v-model="message" placeholder="請輸入訊息...." class="input"></textarea>
        <button @click="send"><i class="fa fa-paper-plane-o"></i></button>
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
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
.composer {
    // box-shadow: 0 -20px 20px -5px #fff;
    //  margin-top: 30px;
    position: relative;
    border-top: 1px solid lightgray;
    background: #f8f8f8;
  textarea {
    width: 90%;
    border-radius: 15px !important;
    font-size: 15px;
    border: 0;
    padding: 15px 20px;
    margin: 15px 15px;
    resize: none;
    height: 60px;
    background: #E6EAEA;
  }
  textarea:focus { 
    outline: none !important;
    border-color:none;
}
  button {
    position: absolute;
    top: 0;
    right: 0;
    border: 0;
    height: 100%;
    width: 60px;
    font-size: 25px;
     color: #f5f5f5;
    background: #32465a;
    cursor: pointer;
  }
  button:hover {
     background: #435f7a;
}
}
</style>