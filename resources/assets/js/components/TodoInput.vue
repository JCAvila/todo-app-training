<template>
    <form method= "POST" v-on:submit.prevent="addTodo">
        <div class="box">
            <div class="field is-grouped">
                <p class="control is-expanded">
                    <input class="input" type="text" placeholder="Nuevo recordatorio" :value="todoItemText" @input="changeText">
                </p>
                <p class="control">
                    <a class="button is-info" @click="addTodo">
                        Agregar
                    </a>
                </p>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        computed: {
            todoItemText(){
                return this.$store.getters.getTodoItemText;
            }
        },
        methods: {
            changeText(event){
                this.$store.dispatch('changeText',event);
            },
            addTodo () {
                this.$store.dispatch('addTodo');
            },
        }
    }
</script>