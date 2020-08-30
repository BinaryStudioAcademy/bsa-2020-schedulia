<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            {{ lang.STATUS }}
        </div>
        <VMenu
            v-model="menu"
            max-width="290"
            :close-on-content-click="false"
            offset-y
        >
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                    :ripple="false"
                    :hover="false"
                    class="filter-menu__button"
                    text
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ lang.ACTIVE_EVENTS }}
                    {{ lang.ALL_EVENTS }}
                    {{ lang.CANCELED_EVENTS }}
                    <VIcon>mdi-chevron-down</VIcon>
                </VBtn>
            </template>

            <VCard class="status-filter">
                <VList>
                    <VListItem>
                        <VListItemContent>
                            <VContainer fluid>

                            </VContainer>
                            <VContainer class="filter-button">
                                <VBtn
                                    @click="closeMenu"
                                    class="cancel-button"
                                    outlined
                                >
                                    {{ lang.CANCEL }}
                                </VBtn>
                                <VBtn class="apply-button primary">
                                    {{ lang.APPLY }}
                                </VBtn>
                            </VContainer>
                        </VListItemContent>
                    </VListItem>
                </VList>

                <VDivider></VDivider>
            </VCard>
        </VMenu>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'Status',

    data() {
        return {
            menu: false,
        };
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
    },

    methods: {
        closeMenu() {
            this.menu = false;
        }
    }
};
</script>

<style lang="scss" scoped>
    .status-filter {
        .v-list-item__content::v-deep {
            padding-top: 0;
        }

        .container.container--fluid::v-deep {
            padding-top: 0;
        }
    }
</style>
