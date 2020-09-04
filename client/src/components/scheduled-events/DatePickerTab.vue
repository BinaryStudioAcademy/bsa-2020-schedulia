<template>
    <VMenu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="date"
        transition="scale-transition"
        offset-y
        min-width="290px"
    >
        <template v-slot:activator="{ on, attrs }">
            <VTab v-model="date" v-bind="attrs" v-on="on">
                {{ lang.DATE_RANGE }}
            </VTab>
        </template>
        <VDatePicker v-model="dates" no-title scrollable range>
            <VContainer class="filter-button" text-align="center">
                <VRow>
                    <VCol>
                        <VBtn @click="closeMenu" class="cancel-button" outlined>
                            {{ lang.CANCEL }}
                        </VBtn>
                    </VCol>
                    <VCol>
                        <VBtn
                            class="apply-button primary"
                            @click="dateRangeRoutePush"
                        >
                            {{ lang.APPLY }}
                        </VBtn>
                    </VCol>
                </VRow>
            </VContainer>
        </VDatePicker>
    </VMenu>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'DatePickerTab',

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    data: () => ({
        tab: null,
        dates: [new Date().toISOString().substr(0, 10)],
        menu: false
    }),

    methods: {
        closeMenu() {
            this.menu = false;
        },

        dateRangeRoutePush() {
            this.closeMenu();

            this.$router.push({
                name: 'DateRange',
                query: {
                    start_date: this.dates[0],
                    end_date: this.dates[1]
                }
            });
        }
    }
};
</script>

<style lang="scss" scoped>
.v-picker::v-deep {
    .v-date-picker-table {
        height: 200px;
    }
}
.v-tab {
    text-transform: none;
}
</style>
