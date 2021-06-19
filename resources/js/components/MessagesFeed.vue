<template>
     <div class="px-lg-2"  style="height:455px;">
        <div class="chat-conversation p-3" ref="feed" style="overflow:scroll;max-height: 455px;">
            <ul v-if="contact" class="list-unstyled mb-0">
                <!-- <li class="chat-day-title"> 
                    <div class="title">Today</div>
                </li> -->
                <li v-for="message in messages" :class="`${message.to == contact.id ? ' sent' : ' right'}`" :key="message.id">
                    <div class="conversation-list">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content">
                                 <h5 class="font-size-14 conversation-name"><a href="#" class="text-dark">{{ message.to == contact.id ? '你' : contact.name }}</a> <span class="d-inline-block font-size-12 text-muted ms-2">{{ dateFormat(message.created_at)}}</span></h5>
                                 <p class="mb-0">
                                    {{ message.text }}
                                </p>
                            </div>
                            <div class="dropdown align-self-start">
                                <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">刪除</a>
                                </div>
                            </div>
                        </div>
                    </div>           
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            },
            user:{
               type: Object,
               required: true,
            }
        },
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            },
            dateFormat(time) {
                let date=new Date(time);
                let hours = date.getHours()<10 ? "0"+date.getHours() : date.getHours();
                let minutes = date.getMinutes()<10 ? "0"+date.getMinutes() : date.getMinutes();
                let seconds =date.getSeconds()<10 ? "0"+date.getSeconds() : date.getSeconds();
                return hours+":"+minutes+":"+seconds;
            }
        },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>