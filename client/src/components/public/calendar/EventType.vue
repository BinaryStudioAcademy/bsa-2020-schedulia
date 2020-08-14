<template>
    <VRow class="ma-0 pa-0">
        <VCol :class="colEventInfoClass">
            <DetailLayout
                :companyLogo="owner.companyLogo"
                :avatar="owner.avatar"
                :name="owner.name"
                :company="owner.company"
                :specialty="owner.specialty"
            >
                <div class="event-info">
                    <VIcon dark color="primary">mdi-clock-outline</VIcon>
                    {{ meetingData.duration }} {{ lang.DURATION_MIN }}
                </div>
                <div class="event-info">
                    <VIcon dark color="primary">mdi-map-marker</VIcon>
                    {{ meetingData.location }}
                </div>
            </DetailLayout>
        </VCol>

        <VDivider vertical class="hidden-md-and-down"></VDivider>

        <VCol sm="12" md="6" lg="5" class="calendar-container col-12">
            <div class="calendar-content">
                <h3>{{ lang.SELECT_DATE_AND_TIME }}</h3>
                <VDatePicker
                    v-model="date"
                    min="2020-08-10"
                    :first-day-of-week="1"
                    :weekday-format="getDay"
                    :header-date-format="dateFormat"
                    no-title
                    :full-width="true"
                    color="primary"
                    flat
                    is-inline
                ></VDatePicker>
            </div>
        </VCol>
        <VDivider v-if="show" vertical class="hidden-md-and-down"></VDivider>
        <VCol
            v-if="show"
            sm="12"
            md="4"
            lg="3"
            class="select-time-container col-12"
        >
            <h3>{{ formattedDate }}</h3>
            <div class="time-items-container">
                <div v-for="(item, i) in availableTimes" :key="i" text>
                    <div v-if="selectedTime === i">
                        <div class="confirm-event">
                            <VCard
                                outlined
                                class="selected-time-card align-center"
                            >
                                <VCardText
                                    dense
                                    class="text-center pa-0 justify-center primary--text font-weight-bold"
                                    >{{ item }}</VCardText
                                >
                            </VCard>
                            <VBtn
                                class="select-time-btn"
                                depressed
                                color="primary"
                                dark
                                :to="{ path: 'confirm-event' }"
                                >{{ lang.CONFIRM_DATE }}</VBtn
                            >
                        </div>
                    </div>
                    <VBtn
                        class="select-time-item"
                        color="primary"
                        outlined
                        @click="selectTime(i)"
                        v-else
                        >{{ item }}</VBtn
                    >
                </div>
            </div>
        </VCol>
    </VRow>
</template>

<script>
import moment from 'moment';
import enLang from '@/store/modules/i18n/en';
import DetailLayout from './DetailLayout';

export default {
    name: 'EventType',
    components: {
        DetailLayout
    },
    data: () => ({
        lang: enLang,
        date: '',
        selectedTime: null,
        meetingData: {
            duration: 20,
            location: 'Scranton, Pennsylvania'
        },
        availability: {
            startDate: '08:00',
            endDate: '18:00'
        },
        owner: {
            name: 'Michael Scott',
            avatar:
                'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
            company: 'Dunder Mifflin',
            companyLogo:
                'https://i.etsystatic.com/16438614/r/il/c31bd2/1806659071/il_570xN.1806659071_pn8j.jpg',
            specialty: 'Sales manager'
        },
        availableTimes: [
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

    computed: {
        colEventInfoClass() {
            const base = 'pa-0 col-md-5 col-sm-12 col-12';
            let lgSize;
            if (this.show) {
                lgSize = 'col-lg-3';
            } else {
                lgSize = 'col-lg-5';
            }
            return [lgSize, base];
        },
        show() {
            return this.date === '' ? false : true;
        },
        formattedDate() {
            return moment(this.date).format('dddd, MMMM D');
        }
    },
    methods: {
        dateFormat(date) {
            const [year, month] = date.split('-');
            if (month) {
                return this.lang.MONTHS[month - 1] + ' ' + year;
            } else {
                return year;
            }
        },
        selectTime(index) {
            this.selectedTime = index;
        },
        getDay(date) {
            let i = new Date(date).getDay(date);
            return this.lang.WEEK_DAYS[i];
        }
    }
};
</script>

<style scoped>
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

.calendar-container {
    min-width: 350px;
    margin: 0;
}

.calendar-content {
    display: flex;
    width: 100%;
    flex-wrap: wrap;
    max-width: 400px;
    justify-content: center;
}

.calendar-container h3 {
    margin: 50px 0 10px 0;
    width: 100%;
    padding-left: 30px;
}

.select-time-container {
    margin: 0 auto;
}

.select-time-container h3 {
    margin: 50px 0 10px 0;
}

.time-items-container {
    overflow-y: scroll;
    min-width: 200px;
    max-height: 600px;
    width: 100%;
    padding: 5px;
}

.select-time-item {
    display: flex;
    width: 100%;
    justify-content: center;
    border-radius: 3px;
    border: 1px solid var(--v-primary-base);
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
    border: 1px solid var(--v-primary-base);
    padding: 6px;
}

::-webkit-scrollbar {
    width: 3px;
}

::-webkit-scrollbar-thumb {
    background: var(--v-primary-base);
}

@media (max-width: 1263px) {
    .calendar-container {
        margin: 20px;
    }
    .select-time-container h3 {
        margin-top: 20px;
    }
    .calendar-container h3 {
        margin-top: 20px;
    }
}

@media (max-width: 960px) {
    .calendar-container {
        padding: 0;
    }
    .calendar-container h3 {
        padding-left: 20px;
    }
    .select-time-container {
        padding-left: 10px;
    }
    .select-time-container h3 {
        margin-left: 20px;
    }
    .calendar-content {
        justify-content: flex-start;
    }
}

@media (max-width: 600px) {
    .calendar-container {
        padding: 0;
    }
}

@media (max-width: 420px) {
    .calendar-container {
        min-width: 320px;
        margin: 20px 0;
    }
}
</style>
