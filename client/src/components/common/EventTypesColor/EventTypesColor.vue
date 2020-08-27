<template>
    <img
            class=""
            :src="colorById[this.eventTypesColor]"
    />
</template>

<script>
    export default {
        name: "EventTypesColor",

        data() {
            return {
                colorById: {
                    yellow: require('@/assets/images/yellow_circle.png'),
                    red: require('@/assets/images/red_circle.png'),
                    blue: require('@/assets/images/blue_circle.png'),
                    green: require('@/assets/images/green_circle.png')
                },
            };
        },

        props: {
            eventTypesColor: {
                type: String,
                required: true
            }
        },
    };
</script>

<style scoped>

</style>
