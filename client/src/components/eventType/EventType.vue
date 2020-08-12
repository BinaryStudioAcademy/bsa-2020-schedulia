<template>
    <VContainer>
        <VRow class="main">
            <VCol sm="12" md="3" class="event-info-container">
                <div class="event-info-top"></div>
                <div class="event-info-content">
                    <VAvatar size="70px" class="avatar-container">
                        <img
                            src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460"
                            alt="Avatar"
                        />
                    </VAvatar>
                    <h4>Michael Scott</h4>
                    <p>Sales manager</p>
                    <div class="event-info">
                        <VIcon dark color="#281ac8">mdi-clock-outline</VIcon>
                        15 {{ lang.ET_MIN }}
                    </div>
                    <div class="event-info">
                        <VIcon dark color="#281ac8">mdi-map-marker</VIcon
                        >Scranton, Pennsylvania
                    </div>
                </div>
            </VCol>

            <VCol sm="8" md="5" lg="4" class="calendar-container">
                <h3>{{ lang.ET_SELECT_DATE_AND_TIME }}</h3>
                <Calendar />
            </VCol>

            <VCol sm="12" md="3" offset-lg="1" class="select-time-container">
                <h3>Tuesday, August 11</h3>
                <div class="time-itms-container">
                    <div v-for="(item, i) in times" :key="i" text>
                        <div v-if="selectedTime === i">
                            <div class="confirm-event">
                                <VCard
                                    elevation="0"
                                    class="selected-time-card align-center"
                                >
                                    <VCardText
                                        dense
                                        class="text-center pa-0 justify-center"
                                        >{{ item }}</VCardText
                                    >
                                </VCard>
                                <VBtn
                                    class="select-time-btn"
                                    depressed
                                    color="#281ac8"
                                    dark
                                    >{{ lang.ET_CONFIRM_DATE }}</VBtn
                                >
                            </div>
                        </div>
                        <VBtn
                            class="select-time-item"
                            color="#281ac8"
                            outlined
                            @click="selectTime(i)"
                            v-else
                            >{{ item }}</VBtn
                        >
                    </div>
                </div>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
// @ is an alias to /src
import Calendar from '@/components/eventType/Calendar.vue';
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'EventType',
    components: {
        Calendar
    },
    data: () => ({
        lang: enLang,
        selectedTime: null,
        times: [
            '9:00',
            '9:30',
            '10:00',
            '10:30',
            '11:00',
            '11:30',
            '12:00',
            '12:30',
            '13:00',
            '13:30',
            '14:00',
            '14:30',
            '15:00',
            '15:30',
            '16:00'
        ]
    }),
    methods: {
        selectTime(index) {
            this.selectedTime = index;
        }
    }
};
</script>

<style>
.main {
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
    background-color: #fff;
}

.event-info {
    display: flex;
    padding: 6px 0 6px 0;
    margin-top: 20px;
}

.event-info ~ .event-info {
    margin-top: 0px;
}

.event-info i {
    margin-right: 10px;
}

.event-info-container {
    padding: 0;
    border-right: 2px solid rgb(243, 247, 247);
}

.event-info-content {
    margin-top: -50px;
    padding-left: 50px;
}

.event-info-content h4 {
    margin-top: 15px;
}

.event-info-top {
    height: 100px;
    background-color: rgb(243, 247, 247);
}

.calendar-container {
    margin: 50px 30px;
}

.calendar-container h3 {
    margin-bottom: 15px;
}

.select-time-container {
    border-left: 2px solid rgb(243, 247, 247);
    padding-left: 30px;
}

.select-time-container h3 {
    margin: 50px 0 10px 0;
}

.time-itms-container {
    overflow-y: scroll;
    min-width: 200px;
    max-height: 600px;
    padding: 5px;
}

.select-time-item {
    display: flex;
    width: 100%;
    justify-content: center;
    border-radius: 3px;
    border: 1px solid #281ac8;
    color: #281ac8;
    font-weight: bold;
    margin: 5px 0;
    cursor: pointer;
}

.confirm-event {
    display: flex;
    justify-content: space-between;
}

.select-time-btn {
    width: 48%;
}

.selected-time-card {
    width: 48%;
    border: 1px solid #281ac8 !important;
    padding: 6px;
}

.selected-time-card div {
    color: #281ac8 !important;
    font-weight: bold !important;
}

::-webkit-scrollbar {
    width: 3px;
}

::-webkit-scrollbar-thumb {
    background: #281ac8;
}

@media (max-width: 1263px) {
    .calendar-container {
        margin: 20px;
    }
    .select-time-container h3 {
        margin-top: 20px;
    }
}

@media (max-width: 959px) {
    .event-header button {
        margin-left: 20px;
    }
    .select-time-container {
        padding-left: 10px;
    }
    .select-time-container h3 {
        margin-left: 20px;
    }
}

@media (max-width: 415px) {
    .calendar-container {
        margin: 20px 0;
    }
}
</style>
