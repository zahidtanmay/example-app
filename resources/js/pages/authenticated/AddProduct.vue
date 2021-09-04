<template>
    <div>
        <h3>Add Product</h3>

        <div class="card">

            <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                {{ errors[0] }}
            </div>

            <div class="card-body">
                <div class="container">
                    <form class="row">
                        <div class="col-md-12 form-group">
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Name"
                                required
                            />
                            <span class="text-danger" v-if="errors.name">
                                {{ errors.name[0] }}
                            </span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="form-label" for="image-add-btn">Add Photo</label>
                            <input type="file" name="image" id="image-add-btn" accept="image/*" ref="imageInput" @change="onFileChange()" />
                            <span class="text-danger" v-if="errors.photo">
                                {{ errors.photo[0] }}
                            </span>
                        </div>

                        <div class="col-md-12 form-group">
                            <datepicker
                                format="yyyy"
                                minimum-view="year"
                                name="manufactured_year"
                                id="input-id"
                                input-class="form-control"
                                v-model="year"
                                placeholder="Manufactured Year"
                                @changedYear="changeYear"
                            >
                            </datepicker>
                            <span class="text-danger" v-if="errors.manufactured_year">
                                {{ errors.manufactured_year[0] }}
                            </span>
                        </div>

                        <button type="submit" class="btn btn-primary" @click.prevent="addProduct()">Add Product</button>

                    </form>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
import Product from "../../src/apis/Product";
import Datepicker from 'vuejs-datepicker';


export default {
    data: () => ({
        form: {
            name: '',
            photo: null,
            photo_locator: null,
            manufactured_year: '',
            file: null,
            year: ''
        },
        year: '',
        errors: []
    }),
    components: {
        Datepicker
    },
    methods: {
        async addProduct() {
            try {
                let res = await Product.store(this.form)
            } catch (error) {
                console.log(error.response)
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status === 401) {
                    this.errors = []
                    this.errors.push('Credential does not match');
                }
            }
        },
        async deleteTodo(id, index) {
            await Product.delete(id)
            this.todos.splice(index, 1)
        },
        async completeTodo(id, index) {
            let res = await Product.update(id)
            this.todos.splice(index, 1, res.data)
        },
        onFileChange() {
            const file   = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader()
            reader.readAsDataURL(file)
            reader.onload = e => {
                this.imageEdited = true
                this.form.photo = e.target.result
                this.form.photo_locator = file.name
            }
        },
        changeYear(val) {
            console.log(val)
        }
    },
    watch: {
        year(val) {
            let d = new Date(val)
            this.form.manufactured_year = d.getFullYear()
        }
    }
}
</script>
