<template>
    <div class="row">
        <div class="col-md-6 row">
            <div class="col-md-1 text-right">
                <VAvatar color="teal" size="48">
                    <span class="white--text headline">48</span>
                </VAvatar>
            </div>

            <div class="col">
                <span>Name Surname</span>
                <br />
                <a>shedulia.xyz/nickname</a>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <VBtn class="ma-2" outlined color="indigo">
                New Event Type
                <VIcon right dark>mdi-plus</VIcon>
            </VBtn>
            <VBtn class="ma-2 text-left" outlined fab small color="indigo">
                <VIcon dark>mdi-chevron-down</VIcon>
            </VBtn>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ActionBlock'
};
</script>

<style scoped></style>
