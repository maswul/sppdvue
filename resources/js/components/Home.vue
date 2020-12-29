<template>
    <div class="card">
        <h1>HelloBebe</h1>
        <v-idle
            @idle="onidle"
            :loop="true"
            :reminders="[7]"
            :wait="5"
            :duration="900"
        />
    </div>
</template>

<script>
    export default{
        methods: {
            onidle() {
                alert('Sesi anda terkunci, silahkan login lagi!');
                window.location.replace("/login/manual/locked.html");
            },
        },
    };
</script>
