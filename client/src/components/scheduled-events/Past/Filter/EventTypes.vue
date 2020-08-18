<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            Event Types
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
                    <span v-if="!eventTypes.length">
                        All Event Types
                    </span>
                    <span v-else>
                        {{ eventTypes.length }} Event Types
                    </span>
                    <VIcon>mdi-chevron-down</VIcon>
                </VBtn>
            </template>

            <VCard>
                <VList>
                    <VListItem>
                        <VListItemContent>
                            <VTextField
                                solo
                                hide-details
                                dense
                                flat
                                color="#2C2C2C"
                                background-color="rgba(224, 224, 224, 0.3)"
                                label="Search"
                                clearable
                                prepend-inner-icon="mdi-magnify"
                            ></VTextField>
                            <VContainer class="filter-form" fluid>
                                <VBtn
                                        :ripple="false"
                                        :hover="false"
                                        class="filter-form__button"
                                        text
                                >
                                    select all
                                </VBtn>
                                \
                                <VBtn
                                        :ripple="false"
                                        :hover="false"
                                        class="filter-form__button"
                                        text
                                >
                                    clear
                                </VBtn>
                                <div class="filter-form__checkbox">
                                    <VCheckbox
                                        hide-details
                                        label="15 Minute Meeting"
                                        v-model="eventTypes"
                                        value="1"
                                    ></VCheckbox>
                                    <VCheckbox
                                        hide-details
                                        label="30 Minute Meeting"
                                        v-model="eventTypes"
                                        value="2"
                                    ></VCheckbox>
                                    <VCheckbox
                                        hide-details
                                        label="60 Minute Meeting"
                                        v-model="eventTypes"
                                        value="3"
                                    ></VCheckbox>
                                    <VCheckbox
                                        hide-details
                                        label="Day meeting"
                                        v-model="eventTypes"
                                        value="4"
                                    ></VCheckbox>
                                    <VCheckbox
                                        hide-details
                                        label="Skype call"
                                        v-model="eventTypes"
                                        value="5"
                                    ></VCheckbox>
                                    <VBtn
                                            :ripple="false"
                                            :hover="false"
                                            class="filter-form__button more"
                                            text
                                            v-if="!moreEventTypes"
                                            @click="showMoreEventTypes"
                                    >
                                        Show more
                                    </VBtn>
                                    <div v-else>
                                        <VCheckbox
                                                hide-details
                                                label="Viber call"
                                                v-model="eventTypes"
                                                value="6"
                                        ></VCheckbox>
                                        <VCheckbox
                                                hide-details
                                                label="Phone call"
                                                v-model="eventTypes"
                                                value="7"
                                        ></VCheckbox>
                                    </div>
                                </div>
                            </VContainer>
                            <VContainer class="filter-button">
                                <VBtn
                                    @click="closeMenu"
                                    class="cancel-button"
                                    outlined
                                >
                                    Cancel
                                </VBtn>
                                <VBtn class="apply-button primary">
                                    Apply
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
export default {
    name: 'EventTypes',

    data() {
        return {
            menu: false,
            eventTypes: ["1"],
            moreEventTypes: false
        };
    },

    methods: {
        closeMenu() {
            this.menu = false;
        },

        showMoreEventTypes() {
            this.moreEventTypes = true;
        },

        selectedEventTypes() {
            return this.eventTypes.length;
        }
    }
};
</script>
