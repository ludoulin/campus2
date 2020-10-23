<template>
    <div class="contacts-list">
        	<div id="profile">
			<div class="wrap">
				<img id="profile-img" :src="user.avatar" class="online" :alt="user.name" />
				<p>{{user.name}}</p>
				<div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div>
			</div>
		</div>
        <ul>
            <li v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact.id == selected }">
                <div class="avatar">
                    <img :src="contact.avatar? contact.avatar:'https://www.kindpng.com/picc/m/269-2697881_computer-icons-user-clip-art-transparent-png-icon.png'" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="name">{{ contact.name }}</p>
                    <p class="email">{{ contact.email }}</p>
                </div>
                <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
            </li>
        </ul>
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
                        return 0;
                    }

                    return contact.unread;
                }]);
            }
        }
    }
</script>
<style lang="scss" scoped>
.contacts-list {
    // position: absolute;
    // height: 600px;
    // border-left: 1px solid #eee;
    //background-color: #120023;
    //  background: linear-gradient(#4768b5, #35488e);
    width: 20%;
    height: 100%;
    float: left;
    overflow: scroll;
    border-right: 1px solid #eee;
    background-color: #2c3e50;
    #profile {
      width: 80%;
      margin: 25px auto;
        .wrap {
        height: 60px;
        line-height: 60px;
        overflow: hidden;
        // -moz-transition: 0.3s height ease;
        // -o-transition: 0.3s height ease;
        // -webkit-transition: 0.3s height ease;
        // transition: 0.3s height ease;
          img {
            width: 50px;
            border-radius: 50%;
            padding: 4px;
            border: 3.5px solid #e74c3c;
            background-color:#eee;
            height: auto;
            float: left;
            cursor: pointer;
            -moz-transition: 0.3s border ease;
            -o-transition: 0.3s border ease;
            -webkit-transition: 0.3s border ease;
            transition: 0.3s border ease;
            }
            img.online {
                border: 3.5px solid #2ecc71;
                }
            img.offline {
                border: 2px solid #95a5a6;
                }  
            p {
                float: left;
                margin-left: 15px;
                color:#eee;
                font-size:14px;
              }
          #status-options {
                position: absolute;
                opacity: 0;
                visibility: hidden;
                width: 150px;
                margin: 70px 0 0 0;
                border-radius: 6px;
                z-index: 99;
                line-height: initial;
                background: #435f7a;
                -moz-transition: 0.3s all ease;
                -o-transition: 0.3s all ease;
                -webkit-transition: 0.3s all ease;
                transition: 0.3s all ease;
                  ul {
                    overflow: hidden;
                    border-radius: 6px;
                     li {
                        padding: 15px 0 30px 18px;
                        display: block;
                        cursor: pointer;
                            p {
                            padding-left: 12px;
                            }
                           span.status-circle {
                            position: absolute;
                            width: 10px;
                            height: 10px;
                            border-radius: 50%;
                            margin: 5px 0 0 0;
                            }
                          span.status-circle:before {
                            content: '';
                            position: absolute;
                            width: 14px;
                            height: 14px;
                            margin: -3px 0 0 -3px;
                            background: transparent;
                            border-radius: 50%;
                            z-index: 0;
                            }  
                        }
                     li:hover {
                        background: #496886;
                        }
                     li#status-online {
                        span.status-circle {
                                background: #2ecc71;
                            }
                        }
                        li#status-online.active span.status-circle:before {
                                border: 1px solid #2ecc71;
                            }     
                     li#status-offline {
                         span.status-circle {
                                background: #95a5a6;
                            }
                        }
                        li#status-online.active span.status-circle:before {
                                border: 1px solid #95a5a6;
                            }               
                    }
                }
          #status-options.active {
                opacity: 1;
                visibility: visible;
                margin: 75px 0 0 0;
            }   
          #status-options:before {
                content: '';
                position: absolute;
                width: 0;
                height: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 8px solid #435f7a;
                margin: -8px 0 0 24px;
            }     
        }
    }
    ul {
        list-style-type: none;
        padding-left: 0;

        li {
             // border-bottom: 1px solid #aaaaaa;
            display: flex;
            padding: 2px;
            height: 80px;
            position: relative;
            cursor: pointer;
            // border-bottom: 1px solid #E6EAEA;

            &.selected {
                background: #1853db;
            }

            span.unread {
                background: #82e0a8;
                color: #fff;
                position: absolute;
                right: 11px;
                top: 20px;
                display: flex;
                font-weight: 700;
                min-width: 20px;
                justify-content: center;
                align-items: center;
                line-height: 20px;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 3px;
            }

            .avatar {
                flex: 1;
                display: flex;
                align-items: center;

                img {
                    width: 35px;
                    border-radius: 50%;
                    margin: 0 auto;
                    background: #eee
                }
            }


            .contact {
                flex: 4;
                font-size: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;

                p {
                    margin: 0;
                    color: #eee;

                    &.name {
                        font-weight: bold;
                    }
                }
            }
            @media(max-width: 768px){
              div.contact{
                display:none;
                }
            }
        }
        li:hover {
            background: #496886;
            }
    }
}
</style>