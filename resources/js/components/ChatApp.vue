<template>
   <div class="d-lg-flex mb-4">
        <ContactsList :contacts="contacts" :user="user" @selected="startConversationWith" ref="contactlist"/>
        <Conversation :contact="selectedContact" :messages="messages" :user="user" @new="saveNewMessage"/>
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        props: {
            user: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                selectedContact:null,
                messages: [],
                contacts: [],
            };
        },
        mounted() {
             console.log(this.user); 
             console.log(this.contacts); 
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.hanleIncoming(e.message);
                });

            axios.get('contacts')
                .then((response) => {
                    this.contacts = response.data;
                    this.$refs.contactlist.selectContact(this.contacts[0]);  
                });
        },
        methods: {
            startConversationWith(contact) {
                this.updateUnreadCount(contact, true);

                axios.get(`conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },
            saveNewMessage(message) {
                this.messages.push(message);
            },
            hanleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                      axios.get(`conversation/read/${message.from}`)
                        // .then((response) => {
                        //      console.log(response.data);
                        // })
                    return;
                }

                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }

                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;

                    return single;
                })
            }
        },
        components: {Conversation, ContactsList}
    }
</script>