<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :class="`message${message.to == contact.id ? ' sent' : ' received'}`" :key="message.id" :data-aos="`${message.to == contact.id ? 'fade-right': 'fade-left'}`">
                <div>
                    <img :src="`${message.to == contact.id ? user.avatar : contact.avatar}`"/>
                    <div class="text"> 
                    {{ message.text }}
                    </div>
                </div>
                <span class="time">{{message.created_at}}</span>
            </li>
        </ul>
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

<style lang="scss" scoped>
.feed {
    height: 100%;
    background: #E6EAEA;
    overflow: scroll;

    ul {
        list-style-type: none;
        padding: 20px;

        li {
            &.message {
                margin: 10px 0;
                width: 100%;

                .text {
                    max-width: 200px;
                    border-radius: 10px;
                    padding: 12px;
                    display: inline-block;
                }

                &.received {
                    text-align: right;

                    img {
                    float: right;
                    margin: 6px 0 0 8px;
                    }

                    .text {
                        background: #f5f5f5;
                    }
                }

                &.sent {
                    text-align: left;

                    img {
                    margin: 6px 8px 0 0;
                    }

                    .text {
                        background: #32465a;
                        color: whitesmoke;
                    }
                }
            }
            img {
              width: 35px;
              border-radius: 50%;
              float: left;
                }

            span.time{
              color: #747474;
              display: block;
              font-size: 12px;
              margin: 8px 0 0;
                }
        }
    }
}
</style>