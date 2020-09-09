<template>
    <VRow class="ma-0 pa-0" v-if="publicEvent.startDate">
        <VCol class="col-1 col-sm-2 col-md-3"></VCol>
        <VCol class="detail-content col-10 col-sm-8 col-md-6">
            <div class="detail-content-top mt-3 mb-5">
                <VLayout justify-center v-if="eventType.owner.avatar">
                    <img
                        :src="eventType.owner.avatar"
                        class="avatar-image"
                        alt="Avatar"
                    />
                </VLayout>
                <h3 class="text-center mt-5 mb-2">{{ lang.CONFIRMED }}</h3>
                <p class="text-center">
                    {{ lang.YOU_ARE_SCHEDULED_WITH }} {{ eventType.owner.name }}
                </p>
            </div>
            <VDivider></VDivider>
            <div class="detail-content-main mt-3 mb-3">
                <div class="event-info">
                    <VImg
                        :src="colorById[eventType.color].image"
                        alt="event color"
                        :max-width="27"
                        class="mr-2"
                    />
                    <h3 class="d-inline">{{ eventType.name }}</h3>
                </div>
                <div class="event-info">
                    <VIcon dark color="primary">mdi-calendar-blank</VIcon>
                    {{ startDateFormatted }}
                </div>
                <div class="event-info">
                    <VIcon dark color="primary">mdi-earth</VIcon>
                    {{ publicEvent.timezone }}
                </div>
                <div v-if="showLocation" class="event-info">
                    <VIcon dark color="primary">mdi-map-marker</VIcon>
                    {{ location }}
                </div>
                <div class="event-info">{{ eventType.description }}</div>
            </div>
            <VDivider></VDivider>
            <div class="detail-content-bottom mt-5">
                <p class="text-center font-weight-bold">
                    {{ lang.CALENDAR_INVITATION_HAS_BEEN_SENT }}
                </p>
            </div>
        </VCol>
        <VCol sm="2" md="3" class="col-1"></VCol>
    </VRow>
</template>

<script>
import moment from 'moment';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as getters from '@/store/modules/publicEvent/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'EventTypeDetails',
    data: () => ({
        colorById: {
            yellow: {
                id: 'yellow',
                image: require('@/assets/images/color_circles/yellow_circle.svg')
            },
            red: {
                id: 'red',
                image: require('@/assets/images/color_circles/red_circle.svg')
            },
            blue: {
                id: 'blue',
                image: require('@/assets/images/color_circles/blue_circle.svg')
            },
            green: {
                id: 'green',
                image: require('@/assets/images/color_circles/green_circle.svg')
            },

            purple: {
                id: 'purple',
                image: require('@/assets/images/color_circles/purple_circle.svg')
            },

            turquoise: {
                id: 'turquoise',
                image: require('@/assets/images/color_circles/turquoise_circle.svg')
            },

            pink: {
                id: 'pink',
                image: require('@/assets/images/color_circles/pink_circle.svg')
            },
            dark_blue: {
                id: 'dark_blue',
                image: require('@/assets/images/color_circles/dark-blue_circle.svg')
            }
        }
    }),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('publicEvent', {
            eventType: getters.GET_EVENT_TYPE,
            publicEvent: getters.GET_PUBLIC_EVENT
        }),
        startDateFormatted() {
            return moment
                .tz(this.publicEvent.startDate, this.publicEvent.timezone)
                .format('dddd, YYYY-MM-DD, HH:mm');
        },
        showLocation() {
            if (this.eventType.locationType === 'address') {
                if (this.eventType.address) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        },
        location() {
            if (this.eventType.locationType === 'address') {
                return this.eventType.address;
            } else if (this.eventType.locationType === 'zoom') {
                return 'Zoom meeting';
            } else {
                return 'Whale meeting';
            }
        }
    }
};
</script>

<style scoped>
.event-info {
    display: flex;
    padding: 6px 0 6px 0;
    margin-top: 6px;
}

.event-info i {
    margin-right: 10px;
}
.avatar-image {
    object-fit: cover;
    width: 70px;
    height: 70px;
    border-radius: 50%;
}
</style>
