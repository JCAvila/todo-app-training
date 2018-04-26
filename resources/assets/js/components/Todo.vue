<template>
    <div class="container">
        <TodoInput :todoItemText="todoItemText" @changeText="todoItemText = $event" @addTodo="addTodo"/>
        <table class="table is-bordered is-fullwidth">
            <tr class="is-fullwidth">
                <TodoItem  v-for="(todo, index) in items" :key="index" :id="todo.id" :done="todo.done" :text="todo.text" @toggleDone="toggleDone" @removeTodo="removeTodo"/>
            </tr>
        </table>
    </div>
</template>

<script>
    /**
     * Tips:
     * - En mounted pueden obtener el listado del backend de todos y dentro de la promesa de axios asirnarlo
     *   al arreglo que debe tener una estructura similar a los datos de ejemplo.
     * - En addTodo, removeTodo y toggleTodo deben hacer los cambios pertinentes para que las modificaciones,
     *   addiciones o elimicaiones tomen efecto en el backend asi como la base de datos.
     */

    import TodoItem from './TodoItem.vue';
    import TodoInput from './TodoInput.vue';

    export default {
        components:{
            TodoInput, TodoItem
        },
        data () {
            return {
                todoItemText: '',
                items: [],
            }
        },
        mounted () {
            axios.get('api/todos').then(response => { this.items = response.data });
        },
        methods: {
            addTodo () {
                let text = this.todoItemText.trim()

                if (text !== '') {
                    axios.post('api/todos', {
                        text: text,
                        done: false
                    }).then(response => {
                        this.items.unshift({ text: text, done: false, id: response.data.id });
                        this.todoItemText = '';
                    }).catch(error => {
                        console.log(error.response.data);
                    });
                }
            },
            removeTodo (id) {
                axios.delete('api/todos/'+ id).then(
                    response => {
                        this.items = this.items.filter(item => item.id !== id)
                    }).catch(error => {
                        console.log(error.response.data);
                    });
            },
            toggleDone (id) {
                let todos = this.items.filter(function (item) {
                    return item.id === id;
                });

                let todo = todos[0];

                axios.put('api/todos/'+ id, todo).then(
                    response => todo.done = !todo.done
                ).catch(error => {
                    console.log(error.response.data);
                });
            }
        }
    }
</script>

<style>
    .is-done {
        text-decoration: line-through;
    }
</style>