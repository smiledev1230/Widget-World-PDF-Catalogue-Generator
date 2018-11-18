<template>
    <header class="header fixed-top">
        <nav v-bind:class="{ smallHeader: this.$route.meta.bgColor}">
            <div class="row">
                <div class="col-sm-3">
                    <router-link to="/" class="logo">
                        <img src="~img/WW-Logo.png" alt="logo" />
                    </router-link>
                </div>
                <div class="col-sm-6">
                    <div class="row header-menu text-center">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                            <router-link to="/new_catalogue" class="menu-icon">
                                <img src="~img/new-catalogue.png" alt="menu icon" />
                                <p>NEW CATALOGUE</p>
                            </router-link>
                        </div>
                        <div class="col-sm-4">
                            <router-link to="/recent" class="menu-icon">
                                <img src="~img/recent.png" alt="menu icon" />
                                <p>RECENT</p>
                            </router-link>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
                <div class="col-sm-3 navbar-right">
                    <!--drop downs-->
                    <div>
                        <!-- User Account: style can be found in dropdown-->
                        <b-dropdown class="user user-menu bell_bg user_btn" right link>
                        <span slot="text">
                            <img src="~img/drop-down.png" class="rounded-circle" alt="Logo Icon">
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        </span>
                            <b-dropdown-item exact class="dropdown_content">
                                <a v-b-modal.accountModal class="drpodowtext">
                                    <i class="fa fa-user-o"></i> Account
                                </a>
                            </b-dropdown-item>
                            <b-dropdown-item exact class="dropdown_content">
                                <router-link to="/login" exact class="drpodowtext">
                                    <i class="fa fa-sign-out"></i> Logout
                                </router-link>
                            </b-dropdown-item>
                        </b-dropdown>
                        <b-dropdown class="notifications-menu bell_bg" right link>
                        <span slot="text">
                            <img src="~img/bell-icon.png" class="noti-icon" alt="Bell Icon">
                            <div class="notifications_badge_top">
                                <span class="badge badge-success">2
                                </span>
                            </div>
                        </span>
                            <b-dropdown-item class="dropdownheader socio-tabs1" exact>
                                <div v-for="(note, index) in notifications" :key="index">
                                    <b-dropdown-item exact v-if="note.state != 0">
                                        <div :class="note.state == 1 ? 'view-notification' : 'close-notification'">
                                            <span>{{note.title}}</span>
                                            <div class="float-right">
                                                <b-btn v-if="note.state == 1" class="greenBgColor pl-3 pr-3 view-btn" @click="viewNotify(index)">VIEW</b-btn>
                                                <i v-else class="fa fa-times" aria-hidden="true" @click="notifications[index]['state']=0"></i>
                                            </div>
                                        </div>
                                    </b-dropdown-item>
                                </div>
                            </b-dropdown-item>
                        </b-dropdown>
                    </div>
                </div>
            </div>
        </nav>
        <b-modal id="accountModal" title="Account Details" ref="accountModal" v-model="accountModal" class="catalogue-modal">
            <div class="merchantModalContent">
                <vue-form class="form-horizontal form-validation" :state="formstate">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <label for="username">Name:</label>
                                <input :class="{noEdit: !accountEdit}" v-model="userModel.username" name="username" type="text" required autofocus placeholder="User Name" class="form-control" :readonly="accountEdit ? false : true" />
                                <field-messages name="username" show="$invalid" class="text-danger">
                                    <div slot="required">Username is a required field</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <label for="email">Email Address:</label>
                                <input :class="{noEdit: !accountEdit}" v-model="userModel.email" name="email" type="email" required placeholder="E-mail" class="form-control" :readonly="accountEdit ? false : true" />
                                <field-messages name="email" show="$invalid" class="text-danger">
                                    <div slot="required">Email is a required field</div>
                                    <div slot="email">Email is not valid</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <label for="password">Password:</label>
                                <input :class="{noEdit: !accountEdit}" v-model="userModel.password" name="password" type="password" required placeholder="Password" class="form-control" minlength="4" maxlength="10" :readonly="accountEdit ? false : true" />
                                <field-messages name="password" show="$invalid" class="text-danger">
                                    <div slot="required">Password is required</div>
                                    <div slot="minlength">Password should be atleast 4 characters long</div>
                                    <div slot="maxlength">Password should be atmost 10 characters long</div>
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="pencil-btn" v-model="accountEdit" @click="updateEditState"><i class="fa fa-pencil"></i></div>
                </vue-form>
            </div>
            <div slot="modal-footer" class="w-100">
                <b-btn class="pl-3 pr-3" @click="accountModal=false">CANCEL</b-btn>
                <b-btn class="float-right greenBgColor pl-3 pr-3" @click="updateAccount">UPDATE</b-btn>
            </div>
        </b-modal>
        <b-modal id="notifyModal" title="" ref="notifyModal" v-model="notifyModal" class="catalogue-modal">
            <div class="merchantModalContent text-center mt-3">
                <div v-if="selectedNotify.type=='text'" class="text-notify">
                    <img src="~img/notify-bell.png"/>
                    <p class="notify-title">{{selectedNotify.title}}</p>
                    <p>{{selectedNotify.description}}</p>
                </div>
                <div v-else-if="selectedNotify.type=='image'" class="row image-notify">
                    <div class="col-6 image">
                        <img :src="selectedNotify.url" class="w-100" />
                    </div>
                    <div class="col-6 pt-3 text-left">
                        <img src="~img/notify-bell.png"/>
                        <p class="notify-title">{{selectedNotify.title}}</p>
                        <p>{{selectedNotify.description}}</p>
                    </div>
                </div>
                <div v-else class="video-notify text-center">
                    <vue-plyr :emit="['controls', 'volume']">
                        <video :src="selectedNotify.url">
                            <source :src="selectedNotify.url" type="video/mp4" size="720">
                        </video>
                    </vue-plyr>
                    <p class="notify-title">{{selectedNotify.title}}</p>
                    <p>{{selectedNotify.description}}</p>
                </div>
            </div>
            <div slot="modal-footer" class="w-100">
                <div class="text-center" @click="notifyModal=false">DISMISS</div>
            </div>
        </b-modal>
    </header>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import VuePlyr from 'vue-plyr';
    import options from "src/validations/validations.js";
    Vue.use(VueForm, options);
    Vue.use(VuePlyr);

    export default {
        name: "vueadmin_header",
        data() {
            return {
                formstate: {},
                accountModal: false,
                notifyModal: false,
                accountEdit: false,
                selectedNotify: {},
                userModel: {
                    username: "Addision",
                    email: "add@gmail.com",
                    password: "12345",
                },
                notifications: [
                    {
                        title: 'New Product Launched',
                        type: 'text',
                        description: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
                        state: 1,
                    },
                    {
                        title: 'New Product Video',
                        type: 'video',
                        description: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
                        url: 'http://vjs.zencdn.net/v/oceans.mp4',
                        state: 1,
                    },
                    {
                        title: 'New Product Image',
                        type: 'image',
                        description: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
                        url: 'https://www.slrmag.co.uk/wp-content/uploads/2018/03/What-a-treat-from-Maltesers.jpg',
                        state: 1,
                    },
                    {
                        title: 'New Product Image',
                        type: 'image',
                        description: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
                        state: -1,
                    },
                    {
                        title: 'Product Discontinued',
                        type: 'text',
                        state: -1,
                    },
                ]
            }
        },
        methods: {
            onSubmit: function() {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    this.$router.push("/");
                }
            },
            updateAccount() {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    this.$router.push("/");
                }
                this.accountModal=false;
            },
            updateEditState() {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    this.accountEdit = !this.accountEdit;
                }
            },
            viewNotify(index) {
                this.selectedNotify = this.notifications[index];
                this.notifyModal = false;
                this.$refs.notifyModal.show();
            }
        }
    }
</script>
<style lang="scss">
    @import "./css/customvariables";
    .header {
        nav.smallHeader {
            height: var(--home-header-height);
            .logo {
                line-height: var(--home-header-height);
                img {
                    height: 72px;
                }
            }
            .header-menu {
                .menu-icon {
                    img {
                        max-height: 32px;
                    }
                    p {
                        font-size: small;
                    }
                }
            }
            .navbar-right > div {
                height: var(--home-header-height);
            }
        }
        .notifications-menu.bell_bg {
            .dropdown-menu {
                background-color: $white_color;
                max-height: 280px;
                overflow-y: auto;
                .view-notification {
                    padding: 12px 20px;
                    margin-bottom: 2px;
                    background-color: #f4f9ec;
                    color: $green_color;
                    .view-btn {
                        margin-top: -5px;
                    }
                }
                .close-notification {
                    padding: 12px 20px;
                    margin-bottom: 2px;
                    background-color: $grey_bgColor;
                    color: $grey_btn_color;
                    .fa-times {
                        font-size: 20px;
                        margin-right: 18px;
                        cursor: pointer;
                    }
                }
                .dropdown-item {
                    cursor: initial;
                }
            }
        }
    }
    #accountModal {
        .modal-body {
            min-height: 166px;
            margin: 15px 15px 0;
            padding: 15px 0;
            background: #ececec;
            .merchantModalContent {
                label {
                    width: 125px;
                    text-align: right;
                }
                .form-control {
                    display: inline-block;
                    width: calc(100% - 160px);
                }
                .noEdit {
                    border: unset;
                    background-color: #ececec;
                }
                .form-control:disabled, .form-control[readonly] {
                    box-shadow: unset;
                }
                .pencil-btn {
                    padding: 0 5px;
                    position: absolute;
                    top: 5px;
                    right: 5px;
                    font-size: 18px;
                    cursor: pointer;
                }
            }
        }
        .modal-footer {
            border-top: unset;
        }
    }
    #notifyModal {
        .modal-header {
            display: none;
        }
        .merchantModalContent {
            img {
                width: 24px;
            }
            .notify-title {
                margin: 10px 0 5px;
                font-size: 16px;
                color: $green_color;
            }
            .image-notify {
                .col-6 {
                    p {
                        padding-left: 0;
                    }
                }
                .image {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }
            }
        }
        .modal-footer {
            background-color: #c6c6c6;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            color: $white_color;
            cursor: pointer;
        }
    }
</style>
