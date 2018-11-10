<template>
    <header class="header fixed-top">
        <nav>
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
                            <router-link to="/" class="menu-icon">
                                <img src="~img/new-catelogue.png" alt="menu icon" />
                                <p>NEW CATELOGUE</p>
                            </router-link>
                        </div>
                        <div class="col-sm-4">
                            <router-link to="/" class="menu-icon">
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
                                <router-link to="/user_profile" exact class="drpodowtext">
                                    <i class="fa fa-user-o"></i> Profile
                                </router-link>
                            </b-dropdown-item>
                            <b-dropdown-item exact class="dropdown_content">
                                <router-link to="/edit_user" exact class="drpodowtext">
                                    <i class="fa fa-cog"></i> Settings
                                </router-link>
                            </b-dropdown-item>
                            <b-dropdown-item exact class="dropdown_content">
                                <router-link to="/lockscreen" exact class="drpodowtext">
                                    <i class="fa fa-lock"></i> Lock
                                </router-link>
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
                                <span class="badge badge-danger">4
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
    </header>
</template>
<script>
    import screenfull from "screenfull"
    export default {
        name: "vueadmin_header",

        methods: {
            toggle_menu() {
                this.$store.commit('left_menu', "toggle");
            },
            fullscreen() {
                if (screenfull.enabled) {
                    screenfull.toggle();
                }
            }

        }
    }
</script>
