<template>
    <div>
        <h3>Todo Dashboard</h3>

        <div class="card">
            <div class="card-header">
                Todos
            </div>

            <div class="card-body">
                <ul>
                    <template v-for="(todo, index) in todos">
                        <li v-if="!todo.completed_at" class="d-flex align-items-center list-group-item">
                            <div
                                class=" border-0 flex-grow-1 text-left shadow-none"
                            >
                                <span>{{ todo.description }}</span>
                            </div>

                            <button
                                class="btn btn-outline-primary border-0 ml-2"
                                @click="completeTodo(todo.id, index)"
                            >
                                Complete
                            </button>
                            <button @click="deleteTodo(todo.id, index)" class="btn btn-outline-danger border-0">
                                Delete
                            </button>
                        </li>
                    </template>
                </ul>

                <div class="container">
                    <form class="row">
                        <div class="col-md-9"><input
                            v-model="newTodo"
                            type="text"
                            class="form-control"
                            placeholder="Create a new to-do..."
                        /></div>
                        <div class="col-md-3" style="text-align: center;">
                            <button :disabled="!newTodo" @click.prevent="addTodo" class="btn btn-primary mb-3">Add New Todo</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                Completed Todos
            </div>
            <div class="card-body">
                <ul>
                    <template v-for="todo in todos">
                        <li v-if="todo.completed_at" class="d-flex align-items-center list-group-item">
                            <button
                                class="btn border-0 flex-grow-1 text-left shadow-none"
                            >
                                <span>{{ todo.description }}</span>
                            </button>

                            <button
                                class="btn border-0 ml-2"
                            >
                                Completed at: {{todo.completed_at}}
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import Todo from "../../src/apis/Todo";

export default {
    data: () => ({
        todos: [],
        newTodo: ''
    }),
    async mounted() {
        let res = await Todo.index()
        this.todos = res.data
    },
    methods: {
        async addTodo() {
            let res = await Todo.store(this.newTodo)
            this.todos.push(res.data)
            this.newTodo = ''
        },
        async deleteTodo(id, index) {
            await Todo.delete(id)
            this.todos.splice(index, 1)
        },
        async completeTodo(id, index) {
            let res = await Todo.update(id)
            this.todos.splice(index, 1, res.data)
        }
    }
}
</script>
