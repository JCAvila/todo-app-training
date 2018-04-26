import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        todoItemText: '',
        items: [],
    },
    getters: {
        getItems(state) {
            return state.items
        },
        getTodoItemText(state) {
            return state.todoItemText
        }
    },
    mutations: {
        loadTask (state){
            axios.get('api/todos').then(response => { state.items = response.data });
        },
        addTodo (state) {
            let text = state.todoItemText.trim()

            if (text !== '') {
                axios.post('api/todos', {
                    text: state.todoItemText,
                    done: false
                }).then(response => {
                    state.items.unshift({ text: text, done: false, id: response.data.id });
                    state.todoItemText = '';
                }).catch(error => {
                    console.log(error.response.data);
                });
            }
        },
        changeText (state, event){
            state.todoItemText = event.target.value;
        },
        removeTodo (state, id) {
            axios.delete('api/todos/'+ id).then(
                response => {
                    state.items = state.items.filter(item => item.id !== id)
                }).catch(error => {
                console.log(error.response.data);
            });
        },
        toogleDone (state, id){
            let todos = state.items.filter(function (item) {
                return item.id === id;
            });

            let todo = todos[0];

            axios.put('api/todos/'+ id, todo).then(
                response => todo.done = !todo.done
            ).catch(error => {
                console.log(error.response.data);
            });
        },
    },
    actions: {
        addTodo(context) {
            context.commit('addTodo')
        },
        changeText(context,event) {
            context.commit('changeText', event)
        },
        removeTodo(context,id) {
            context.commit('removeTodo', id)
        },
        toogleDone(context,id) {
            context.commit('toogleDone', id)
        },
    }
})