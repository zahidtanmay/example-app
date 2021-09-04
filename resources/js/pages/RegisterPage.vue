<template>
    <div class="row mt-5">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    Register
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="loginName" class="form-label">Name</label>
                        <input v-model="form.name" type="text" class="form-control" id="loginName" required>
                        <span class="text-danger" v-if="errors.name">
                            {{ errors.name[0] }}
                        </span>
                    </div>
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
                        <button @click.prevent="register" class="btn btn-primary mb-3" :disabled="!form.email || !form.password">Register</button>
                        <router-link :to="{name: 'login'}">Already have an account?</router-link>
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
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },
            errors: []
        };
    },
    methods: {
        async register() {
            try {
                let res = await User.register(this.form)
                await localStorage.setItem("auth", "true");
                await localStorage.setItem("authToken", res.data.token);
                this.$router.push({ name: "todo-dashboard" });
                this.errors = []
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
};
</script>
