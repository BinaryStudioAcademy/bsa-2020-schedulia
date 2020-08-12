<template>
    <div class="dates">
        <div class="month">
            <VBtn class="arrows prev-mth" text @click="onPrevMonth">&lt;</VBtn>
            <div class="mth">{{ formattedDate }}</div>
            <VBtn class="arrows next-mth" text @click="onNextMonth">&gt;</VBtn>
        </div>
        <div class="days-in-week">
            <div v-for="day in weekDays" :key="day">{{ day }}</div>
        </div>
        <div class="days">
            <div
                v-for="index in firstMthDayInWeek"
                :key="index + 'skipped'"
            ></div>
            <VBtn
                :class="['day', isSelected(dayIndex) && 'white--text']"
                :disabled="dayIndex < startEventDate || dayIndex > endEventDate"
                :color="isSelected(dayIndex) ? '#281ac8' : 'rgb(243, 247, 247)'"
                @click="selectDate(dayIndex)"
                fab
                elevation="0"
                v-for="dayIndex in datesRange"
                :key="dayIndex"
                >{{ dayIndex }}</VBtn
            >
        </div>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'Calendar',
    created() {
        this.months = [
            this.lang.ET_JAN,
            this.lang.ET_FEB,
            this.lang.ET_MAR,
            this.lang.ET_APR,
            this.lang.ET_MAY,
            this.lang.ET_JUN,
            this.lang.ET_JUL,
            this.lang.ET_AUG,
            this.lang.ET_SEP,
            this.lang.ET_OCT,
            this.lang.ET_NOV,
            this.lang.ET_DEC
        ];

        this.weekDays = [
            this.lang.ET_WEEK_DAY_MON,
            this.lang.ET_WEEK_DAY_TUE,
            this.lang.ET_WEEK_DAY_WED,
            this.lang.ET_WEEK_DAY_THU,
            this.lang.ET_WEEK_DAY_FRI,
            this.lang.ET_WEEK_DAY_SAT,
            this.lang.ET_WEEK_DAY_SUN
        ];

        const initialDate = new Date();

        this.populateCalendar(
            new Date(initialDate.getFullYear(), initialDate.getMonth(), 1)
        );
    },

    data: () => ({
        lang: enLang,
        month: null,
        currentMonth: null,
        year: null,
        firstMthDayInWeek: null,
        daysInMonth: null,
        formattedDate: null,
        selectedDate: null,
        startEventDate: 3,
        endEventDate: 22,
        months: [],
        weekDays: [],
        datesRange: {
            from: 1,
            to: null,
            [Symbol.iterator]: function() {
                return {
                    current: this.from,
                    last: this.to,

                    next() {
                        if (this.current <= this.last) {
                            return { done: false, value: this.current++ };
                        } else {
                            return { done: true };
                        }
                    }
                };
            }
        }
    }),
    methods: {
        selectDate(index) {
            this.selectedDate = index;
            this.currentMonth = this.month;
        },
        isSelected(dayIndex) {
            return (
                dayIndex === this.selectedDate &&
                this.currentMonth === this.month
            );
        },
        populateCalendar(newDate) {
            this.setFormattedDate(newDate);

            this.month = newDate.getMonth();
            this.year = newDate.getFullYear();

            if (
                this.month === 0 ||
                this.month === 2 ||
                this.month === 4 ||
                this.month === 6 ||
                this.month === 7 ||
                this.month === 9 ||
                this.month === 11
            ) {
                this.daysInMonth = 31;
            } else if (this.month === 1) {
                let leap =
                    (this.year % 4 === 0 && this.year % 100 !== 0) ||
                    this.year % 400 === 0;
                this.daysInMonth = leap ? 29 : 28;
            } else this.daysInMonth = 30;

            this.datesRange.to = this.daysInMonth;

            let currentDay = newDate.getDay();
            currentDay = currentDay !== 0 ? currentDay : 7;
            this.firstMthDayInWeek = currentDay - 1;
        },
        printDay(day) {
            if (day < this.firstMonthDay) {
                return '';
            } else {
                return day;
            }
        },
        setFormattedDate(newDate) {
            this.formattedDate = `${
                this.months[newDate.getMonth()]
            } ${newDate.getFullYear()}`;
        },
        onPrevMonth() {
            this.month--;

            if (this.month < 0) {
                this.month = 11;
                this.year--;
            }
            this.populateCalendar(new Date(this.year, this.month, 1));
        },
        onNextMonth() {
            this.month++;

            if (this.month > 11) {
                this.month = 0;
                this.year++;
            }
            this.populateCalendar(new Date(this.year, this.month, 1));
        }
    }
};
</script>

<style scoped>
.dates {
    display: inline;
    background-color: #fff;
}

.dates .month {
    display: flex;
    justify-content: space-between;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 20px;
}

.dates .month .mth {
    margin: 0 20px;
    color: #636363;
}

.dates .month .arrows {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #1100ff;
    font-size: 20px;
}

.dates .days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    padding: 10px;
}
.dates .days .day {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 38px;
    height: 38px;
    margin: 5px;
    color: #000;
    background-color: rgb(247, 245, 255);
}

.dates .days .day:hover {
    background-color: rgb(237, 232, 255);
}

.dates .days-in-week {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    padding: 5px;
}

.dates .days-in-week div {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    color: #636363;
    padding: 5px;
}

@media (max-width: 415px) {
    .dates .days .day {
        margin: 1px;
    }
}
</style>
