<template>
    <div class="conversation">
        <div class="select">
            <div class="contact-profile">
                <img v-if="contact" :src="contact.avatar" class="m-r-10">
                <p>{{ contact ? contact.name : 'Select a Contact' }}</p>
                <div class="social-media">
			        <a href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>
			        <a href="javascript:void(0)"><i class="fas fa-copy"></i></a>
                    <a class="btn" href="javascript:void(0)" data-toggle="dropdown" aria-hidden="true">
                        <i class="fa fa-sort"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">Latest</a>
                        </li>
                         <li>
                            <a class="dropdown-item" href="javascript:void(0)">Oldest</a>
                        </li>
                    </ul>        
			    </div>
            </div>
        </div>
        <MessagesFeed :contact="contact" :user="user" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            },
            user:{
               type: Object,
               required: true,
            }
        },
        methods: {
            sendMessage(text) {
                if (!this.contact) {
                    return;
                }

                axios.post('conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                })
            }
        },
        components: {MessagesFeed, MessageComposer}
    }
</script>

<style lang="scss" scoped>
.conversation {
    // position:absolute;
    // max-height: 100%;
    // flex: 3;
    height: 100%;
    width: 80%;
    float: right;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    .select {
        font-size: 20px;
        padding: 9px;
        margin: o;
        border-bottom: 1px solid lightgray;
        box-shadow: 0 -20px 20px -5px #fff;
        background-color: #f8f8f8;
        .contact-profile {
            width: 100%;
            height: 50px;
            line-height: 40px;
            margin:8px;
              
                img {
                    width: 40px;
                    border-radius: 50%;
                    float: left;
                    margin-right:12px
                    // margin: 9px 12px 0 9px;
                    }
                p {
                    float: left;
                  }    

                 .social-media {
                     float: right;
                        i {
                            margin-left: 14px;
                            cursor: pointer;
                          }
                        i:nth-last-child(1) {
                            margin-right: 20px;
                          }
                        i:hover {
                            color: #435f7a;
                            }   
                 }      
            }
    }
}
</style>