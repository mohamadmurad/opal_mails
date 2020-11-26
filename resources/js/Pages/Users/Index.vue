<template>
        <app-layout title="Users">
            <b-table :data="data" :columns="columns"></b-table>
            <div v-for="user in users" :key="user.id">

                <inertia-link :href="`/users/${user.id}`">
                    {{ user.name }}
                </inertia-link>
                <div>{{ user.email }}</div>
            </div>
        </app-layout>
</template>
<script>

import AppLayout from '@/Layouts/AppLayout'


export default {
    components: {
        AppLayout,
    },
    props: {
        users: Array,
    },
    data() {
        return {
            data: Array,
            columns: [
                {
                    field: 'name',
                    label: 'Name',
                },
            ]
        }
    },

    mounted() {
        this.data = this.users;
    },
}
</script>
