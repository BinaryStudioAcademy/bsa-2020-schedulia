<template>
    <img class="" :src="colorById[this.color]" />
</template>

<script>
export default {
    name: 'EventTypesColor',

    data() {
        return {
            colorById: {
                yellow: require('@/assets/images/color_circles/yellow_circle.svg'),
                red: require('@/assets/images/color_circles/red_circle.svg'),
                blue: require('@/assets/images/color_circles/blue_circle.svg'),
                green: require('@/assets/images/color_circles/green_circle.svg'),
                purple: require('@/assets/images/color_circles/purple_circle.svg'),
                turquoise: require('@/assets/images/color_circles/turquoise_circle.svg'),
                pink: require('@/assets/images/color_circles/pink_circle.svg'),
                dark_blue: require('@/assets/images/color_circles/dark-blue_circle.svg')
            }
        };
    },

    props: {
        color: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped></style>
