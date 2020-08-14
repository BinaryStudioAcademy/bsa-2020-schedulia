<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            Tracking ID
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
                    All IDs
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
                            <VContainer fluid>
                                <VCheckbox
                                    hide-details
                                    label="15 Minute Meeting"
                                    value=""
                                ></VCheckbox>
                                <VCheckbox
                                    hide-details
                                    label="30 Minute Meeting"
                                    value=""
                                ></VCheckbox>
                                <VCheckbox
                                    hide-details
                                    label="60 Minute Meeting"
                                    value=""
                                ></VCheckbox>
                                <VCheckbox
                                    hide-details
                                    label="Sales Manager"
                                    value=""
                                ></VCheckbox>
                                <VCheckbox
                                    hide-details
                                    label="Sales Manager"
                                    value=""
                                ></VCheckbox>
                            </VContainer>
                            <VContainer class="filter-button">
                                <VBtn class="cancel-button" outlined>
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
    name: 'TrackingId'
};
</script>
