<template>
    <div class="row mt-5">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    Login
                </div>

                <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                    {{ errors[0] }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email address</label>
                        <input v-model="form.email" type="email" class="form-control" id="loginEmail" required>
                        <span class="text-danger" v-if="errors.email">
                            {{ errors.email[0] }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input v-model="form.password" type="password" class="form-control" id="loginPassword" required>
                        <span class="text-danger" v-if="errors.password">
                            {{ errors.password[0] }}
                        </span>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <button @click.prevent="login" class="btn btn-primary mb-3" :disabled="!form.email || !form.password">Login</button>
                        <router-link :to="{name: 'register'}">Don't have an account?</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import User from "../src/apis/User";
export default {
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            errors: []
        };
    },
    methods: {
        async login() {
            try{
                let res = await User.login(this.form)
                await localStorage.setItem("auth", "true");
                await localStorage.setItem("authToken", res.data.token);
                this.errors = []
                this.$router.push({ name: "dashboard" });
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status === 401) {
                    this.errors = []
                    this.errors.push('Credential does not match');
                }
            }
        }
    }
};
</script>
