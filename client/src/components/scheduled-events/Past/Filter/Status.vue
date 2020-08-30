<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            Status
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
                    Active Events
                    <VIcon>mdi-chevron-down</VIcon>
                </VBtn>
            </template>

            <VCard class="status-filter">
                <VList>
                    <VListItem>
                        <VListItemContent>
                            <VContainer fluid>
                                <VCheckbox
                                    hide-details
                                    label="Active events"
                                    value=""
                                ></VCheckbox>
                                <VCheckbox
                                    hide-details
                                    label="Canceled events"
                                    value=""
                                ></VCheckbox>
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
    name: 'Status',

    data() {
        return {
            menu: false
        };
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
