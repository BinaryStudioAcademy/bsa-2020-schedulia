<template>
    <VRow justify="center">
        <VDialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                        color="primary"
                        dark
                        v-bind="attrs"
                        v-on="on"
                >
                    Change password
                </VBtn>
            </template>
            <VCard>
                <VCardTitle>
                    <span class="headline">Change password</span>
                </VCardTitle>
                <VCardText>
                    <VContainer>
                        <VRow>
                            <VCol cols="12">
                                <VTextField label="Password*" type="password" required></VTextField>
                            </VCol>
                        </VRow>
                    </VContainer>
                    <small>*indicates required field</small>
                </VCardText>
                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn color="blue darken-1" text @click="dialog = false">Close</VBtn>
                    <VBtn color="blue darken-1" text @click="dialog = false">Save</VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </VRow>

</template>

<script>
    export default {
        name: 'LoginForm',
        data: () => ({
            email: 'john.doe@gmail.com',
            password: 'password',
            dialog: false,
        })
    };
</script>
