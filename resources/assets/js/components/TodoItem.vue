<template>
    <div>
        <td class="is-fullwidth" style="cursor: pointer" :class="{ 'is-done': done }" @click="toogleDone(id)">
            {{ text }}
        </td>
        <td class="is-narrow">
            <a class="button is-danger is-small" @click.prevent="removeTodo(id)">Eliminar</a>
        </td>
    </div>
</template>

<script>
    export default{
        props: {
            text: {
                type: String,
                required: true,
            },
            id: {
                type: Number,
                required: true,
            },
            done: {
                type: Boolean,
                required: true,
            }
        },
        methods: {
            removeTodo (id) {
                this.$store.dispatch('removeTodo',id);
            },
            toogleDone (id) {
                this.$store.dispatch('toogleDone',id);
            }
        }
    }
</script>