<template>
    <div>
        <h3>Dashboard</h3>

        <div class="card">
            <div class="card-header">
                Products
                <button @click.prevent="addProduct" class="btn btn-primary mb-3 add-new-btn">Add New Product</button>
            </div>

            <div class="card-body">
                <div class="row">
                    <template v-for="(todo, index) in todos">
                        <div class="card col-md-3" style="width: 18rem;">
                            <img class="card-img-top" :src="`/uploads/${todo.photo}`" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{todo.name}}</h5>
                                <p class="card-text">{{todo.manufactured_year}}</p>
                            </div>

                            <div class="card-body">
                                <a @click="editTodo(todo.id, index)" class="card-link">Edit</a>
                                <a @click="deleteTodo(todo.id, index)" class="card-link">Delete</a>
                            </div>
                        </div>

                    </template>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
import Product from "../../src/apis/Product";

export default {
    data: () => ({
        todos: [],
        newTodo: ''
    }),
    async mounted() {
        let res = await Product.index()
        this.todos = res.data
    },
    methods: {
        async addTodo() {
            let res = await Product.store(this.newTodo)
            this.todos.push(res.data)
            this.newTodo = ''
        },
        async deleteTodo(id, index) {
            await Product.delete(id)
            this.todos.splice(index, 1)
        },
        async completeTodo(id, index) {
            let res = await Product.update(id)
            this.todos.splice(index, 1, res.data)
        },
        editTodo(id, index) {
            this.$router.push(`products/${id}/edit`)
        },
        addProduct() {
            this.$router.push({ name: "add-product" });
        }
    }
}
</script>

<style>
.add-new-btn {
    position: absolute;
    top: 4px;
    right: 4px;
}
</style>
