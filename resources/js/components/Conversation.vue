<template>
    <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
        <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
            <div class="card">
                <div class="p-3 px-lg-4 border-bottom">
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <h5 class="font-size-16 mb-1 text-truncate"><a href="javascript:void(0)" class="text-dark">{{ contact ? contact.name : '請選擇聯絡者' }}</a></h5>
                        </div>
                        <div class="col-md-8 col-6">
                            <ul class="list-inline user-chat-nav text-end mb-0">
                                <li class="list-inline-item">
                                    <div class="dropdown">
                                        <button class="btn nav-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md" style="position:end;">
                                            <form class="p-2">
                                                <div>
                                                    <input type="text" class="form-control rounded" placeholder="Search...">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <MessagesFeed :contact="contact" :user="user" :messages="messages"/>
                <MessageComposer @send="sendMessage"/>
            </div>
        </div>        
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