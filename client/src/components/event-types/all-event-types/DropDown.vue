<template>
    <VMenu nudge-bottom="30" nudge-left="150" close-on-click :close-on-content-click="false">
        <template v-slot:activator="{ on, attrs }">
            <VBtn icon color="primary" v-bind="attrs" v-on="on">
                <VIcon dark>mdi-dots-horizontal</VIcon>
            </VBtn>
        </template>
        <VList>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-calculator</VIcon>
                    Manage availability
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-pencil</VIcon>
                    Edit
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-file-outline</VIcon>
                    Add Internal Note
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-content-copy</VIcon>
                    Clone
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-plus-minus-box</VIcon>
                    Save to Template
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-xml</VIcon>
                    Add to WebSite
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-delete</VIcon>
                    Delete
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <div class="switch-item">
                        <div
                            class="pa-0 ma-0"
                        >
                            On/Off
                        </div>
                        <div class="pa-0 ma-0">
                            <VSwitch inset></VSwitch>
                        </div>
                    </div>
                </VListItemTitle>
            </VListItem>
        </VList>
    </VMenu>
</template>

<script>
export default {
    name: 'DropDown',
    props: {
        eventType: {
            required: true
        }
    }
};
</script>

<style scoped>
.v-list-item {
    cursor: pointer;
}
.v-list-item__title a{
    text-decoration: none;
    color: #000;
}
.switch-item {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.switch-item div:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>