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
                                <b-tabs>
                                    <b-tab title="Notifications" class="tabs_cont" active>
                                        <b-dropdown-item exact>
                                            <div class="row">
                                                <div class="col-2 mt-2 ml-2">
                                                    <img class="rounded-circle" src="~img/authors/avatar1.jpg">
                                                </div>
                                                <div class="col-9 mt-2">
                                                    <p> &nbsp;Lorem ipsum dolor sit amet, elit.
                                                        <br>
                                                        <small class="ml-1 text-info">Today </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact>
                                            <div class="row">
                                                <div class="col-2 mt-2 ml-2">
                                                    <img class="rounded-circle" src="~img/authors/avatar5.jpg">
                                                </div>
                                                <div class="col-9 mt-2">
                                                    <p> &nbsp;Lorem ipsum dolor sit amet, elit.
                                                        <br>
                                                        <small class="ml-1 text-muted">week ago</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact>
                                            <div class="row">
                                                <div class="col-2 mt-2 ml-2">
                                                    <img class="rounded-circle" src="~img/authors/avatar3.jpg">
                                                </div>
                                                <div class="col-9 mt-2">
                                                    <p> &nbsp;Lorem ipsum dolor sit amet, elit.
                                                        <br>
                                                        <small class="ml-1 text-muted">month ago</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="mt-2 notifications_data">
                                            <div class="row">
                                                <div class="col-2 mt-2 ml-2">
                                                    <img class="rounded-circle" src="~img/authors/avatar3.jpg">
                                                </div>
                                                <div class="col-9 mt-2">
                                                    <p> &nbsp;Lorem ipsum dolor sit amet, elit.
                                                        <br>
                                                        <small class="ml-1 text-muted">2 months ago</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item class="dropdown-footer " exact>
                                            <div>
                                                <strong>View all</strong>
                                            </div>
                                        </b-dropdown-item>
                                    </b-tab>
                                    <b-tab title="Events" class="event_date">
                                        <b-dropdown-item exact class="notifications_data">
                                            <div class="noti_item">
                                                <div class="row">
                                                    <div class="col-2   ml-3">
                                                        <i class="fa fa-calendar text-info noti_msg"></i>
                                                    </div>
                                                    <div class="col-9 mt-1">
                                                        <span>New Lorem Event from john.</span>
                                                        <br>
                                                        <span class="text-muted">Apr 29th 2017</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="notifications_data">
                                            <div class="row">
                                                <div class="col-2 ml-3">
                                                    <i class="fa fa-calendar text-info noti_msg"></i>
                                                </div>
                                                <div class="col-9 mt-1">
                                                    <span>New Lorem Event from john.</span>
                                                    <br>
                                                    <span class="text-muted">Apr 29th 2017</span>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item exact class="notifications_data">
                                            <div class="row">
                                                <div class="col-2 ml-3 mb-2">
                                                    <i class="fa fa-calendar text-info noti_msg"></i>
                                                </div>
                                                <div class="col-9 mt-1">
                                                    <span>New Lorem Event from john.</span>
                                                    <br>
                                                    <span class="text-muted">Apr 29th 2017</span>
                                                </div>
                                            </div>
                                        </b-dropdown-item>
                                        <b-dropdown-item class="dropdown-footer">
                                            <div>
                                                <strong>View all</strong>
                                            </div>
                                        </b-dropdown-item>
                                    </b-tab>
                                    <b-tab title="Updates" disabled>
                                    </b-tab>
                                </b-tabs>
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
    </header>
</template>
<script>
    import Vue from 'vue';
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";
    Vue.use(VueForm, options);

    export default {
        name: "vueadmin_header",
        data() {
            return {
                formstate: {},
                accountModal: false,
                accountEdit: false,
                userModel: {
                    username: "Addision",
                    email: "add@gmail.com",
                    password: "12345",
                },
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
            }
        }
    }
</script>
<style lang="scss" scoped>
    .header nav.smallHeader {
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
</style>
<style lang="scss">
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
</style>
