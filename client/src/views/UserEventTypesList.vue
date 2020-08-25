<template>
    <div class="container mt-16">
        <VCard>
            <div class="list-heading text-center">
                <span><b>Dmitriy Fox</b></span><br />
                <span>Welcome to my scheduling page.</span><br />
                <span
                    >Please follow the instructions to add an event to my
                    calendar.</span
                ><br />
            </div>
        </VCard>
    </div>
</template>

<script>
export default {
    name: 'UserEventTypesList'
};
</script>

<style scoped>
.container {
    background: #fff;
}
.list-heading {
    color: gray;
}
</style>