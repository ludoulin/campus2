 <template>
     <div class="chat-leftsidebar card">
            <div class="p-3 px-4">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3 align-self-center">
                        <img :src="user.avatar" class="avatar-xs rounded-circle" :alt="user.name" v-if="user.avatar">
                        <div class="avatar-xs align-self-center" v-if="!user.avatar">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">{{user.name}}<i class="fas fa-circle text-success align-middle font-size-10 ms-1"></i></a></h5>
                        <p class="text-muted mb-0">上線中</p>
                    </div>

                    <div class="flex-shrink-0">
                        <div class="dropdown chat-noti-dropdown">
                            <button class="btn py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" :href="`./users/${user.id}`"><i class="fas fa-id-card pr-1"></i>個人檔案</a>
                                <a class="dropdown-item" :href="`./users/${user.id}/edit`"><i class="fas fa-user-cog pr-1"></i>編輯</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3">
                <div class="search-box chat-search-box">
                    <div class="position-relative">
                        <input type="text" class="form-control bg-light border-light rounded" placeholder="尋找...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
            </div>

            <div class="pb-3">
                <div style="overflow:scroll; max-height: 410px;">
                    <div class="p-4 border-top">
                        <div>
                            <h5 class="font-size-16 mb-3"><i class="far fa-user me-1"></i>全部使用者</h5>

                            <ul class="list-unstyled chat-list">
                                <li v-for="contact in sortedContacts"  :key="contact.id" @click="selectContact(contact)" :class="{ 'active': contact == selected}">
                                    <a href="javascript:void(0)">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div class="user-img online">
                                                    <img :src="contact.avatar" class="rounded-circle avatar-xs" alt="" v-if="contact.avatar">
                                                    <div class="avatar-xs align-self-center" v-if="!contact.avatar">
                                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                           <i class="fas fa-user"></i>
                                                        </span>
                                                    </div>
                                                    <span class="user-status"></span> 
                                                </div>
                                            </div>                                                                
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">{{ contact.name }}</h5>
                                                <!-- <p class="text-truncate mb-0">Hey! there I'm available</p> -->
                                            </div>
                                            
                                            <div class="flex-shrink-0">
                                                <div class="font-size-11">02 min</div>
                                                <div class="unread-message" v-if="contact.unread">
                                                    <span class="badge bg-danger rounded-pill">{{ contact.unread }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            },
             user:{
               type: Object,
               required: true,
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null
            };
        },
        methods: {
            selectContact(contact) {
                this.selected = contact;

                this.$emit('selected', contact);
            }

        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return contact.unread;
                    }

                    return 0;
                }]);
            }
        },
    }
</script>
