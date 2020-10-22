<template>
    <div class="composer">
        <textarea v-model="message" placeholder="What's on your mind..." class="input"></textarea>
        <button @click="send" ><i class="fa fa-paper-plane-o"></i></button>
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
    width: 100%;
    font-size: 15px;
    border: 0;
    padding: 15px 20px;
    resize: none;
    height: 60px;
    background: 0 0;
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
    color: #2196f3;
    background: 0 0;
  }
  button:hover {
    background: #1853db;
}
}
</style>