<template>
    <VRow class="ma-0 pa-0" v-if="publicEvent.startDate">
        <VCol class="col-1 col-sm-2 col-md-3"></VCol>
        <VCol class="detail-content col-10 col-sm-8 col-md-6">
            <div class="detail-content-top mt-3 mb-5">
                <VLayout justify-center v-if="eventType.owner.avatar">
                    <VAvatar :size="70" class="avatar">
                        <img :src="eventType.owner.avatar" alt="Avatar" />
                    </VAvatar>
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
                <div class="event-info">
                    <VIcon dark color="primary">mdi-map-marker</VIcon>Vyacheslav
                    Chornovol Avenue, 59, Lviv
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
                image: require('@/assets/images/yellow_circle.png')
            },
            red: {
                id: 'red',
                image: require('@/assets/images/red_circle.png')
            },
            blue: {
                id: 'blue',
                image: require('@/assets/images/blue_circle.png')
            },
            green: {
                id: 'green',
                image: require('@/assets/images/green_circle.png')
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
            return moment(this.publicEvent.startDate).format(
                'dddd, YYYY-MM-DD, HH:mm'
            );
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
</style>
