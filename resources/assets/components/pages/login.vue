<template>
    <div class="container-fluid img_backgrond">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-sm-6 offset-sm-3 col-xs-10 offset-xs-1 mt-5">
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <img src="~img/logo-icon.png" class="col-sm-6 col-md-4" alt="Logo">
                        </div>
                    </div>
                </div>
                <vue-form class="form-horizontal form-validation" :state="formstate" @submit.prevent="onSubmit">
                    <div class="row">
                        <div class="col-sm-12 mt-3 ">
                            <div class="form-group">
                                <validate tag="div">
                                    <label for="email"> E-mail</label>
                                    <input v-model="model.email" name="email" id="email" type="email" required autofocus
                                           placeholder="E-mail" class="form-control"/>
                                    <field-messages name="email" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">Email is a required field</div>
                                        <div slot="email">Email is not valid</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <validate tag="div">
                                    <label for="password"> Password</label>
                                    <input v-model="model.password" name="password" id="password" type="password"
                                           required placeholder="Password" class="form-control" minlength="4"
                                           maxlength="50"/>
                                    <field-messages name="password" show="$invalid && $submitted" class="text-danger">
                                        <div slot="required">Password is required</div>
                                        <div slot="minlength">Password should be at least 4 characters long</div>
                                        <div slot="maxlength">Password should be at most 10 characters long</div>
                                    </field-messages>
                                </validate>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <validate tag="label">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input checkbox_label" name="remember"
                                           id="remember" v-model="model.remember" check-box>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Remember Me</span>
                                </label>
                                <field-messages name="remember" show="$invalid && $submitted" class="text-danger">
                                    <div slot="check-box">Terms must be accepted</div>
                                </field-messages>
                            </validate>
                        </div>
                        <div class="col-lg-6 col-md-6 text-right">
                            <div class="form-group">
                                <input type="submit" value="Sign In" class="btn btn-success"/>
                            </div>
                        </div>
                    </div>
                </vue-form>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import VueForm from "vue-form";
    import options from "src/validations/validations.js";

    Vue.use(VueForm, options);
    export default {
        name: "login",
        data() {
            return {
                formstate: {},
                model: {
                    email: "",
                    password: ""
                }
            }
        },
        methods: {
            onSubmit() {
                if (this.formstate.$invalid) {
                    return;
                } else {
                    let app = this;
                    let email = app.model.email;
                    let password = app.model.password;
                    axios
                        .post("/api/login", {email, password, access_to_widget: 1})
                        .then(response => {
                            if (response.data && response.data.token) {
                                app.$store.state.user = {
                                    id: response.data.user.id,
                                    group_id: response.data.user.group_id,
                                    name: response.data.user.name,
                                    email: response.data.user.email,
                                    password: password,
                                }
                                localStorage.setItem('token', response.data.token);
                                localStorage.setItem('user',  JSON.stringify(app.$store.state.user));
                                app.$router.push("/");
                            }
                        });
                }
            },

        },
        mounted: function () {
            this.$store.dispatch('initProductData');
        },
        destroyed: function () {

        },
    }
</script>
<style scoped>
    .img_backgrond {
        background-image: url("~img/pages/Login-03-01.png");
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        padding: 75px 15px;
    }

    label {
        font-size: 14px !important;
    }

    ::-webkit-input-placeholder {
        font-size: 14px;
    }
</style>
