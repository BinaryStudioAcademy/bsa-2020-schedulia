<template>
    <VRow justify="center">
        <VDialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <VBtn color="primary" dark v-bind="attrs" v-on="on">
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
                                <VSubheader>Current password</VSubheader>
                                <VTextField
                                    v-model="password"
                                    placeholder="Current password *"
                                    type="password"
                                    :rules="[rules.required]"
                                    required
                                    solo
                                    outlined
                                ></VTextField>
                            </VCol>
                            <VCol cols="12">
                                <VSubheader>New password</VSubheader>
                                <VTextField
                                    v-model="newPassword"
                                    placeholder="New password *"
                                    type="password"
                                    :rules="[
                                        rules.min,
                                        rules.max,
                                        confirmPassword
                                    ]"
                                    required
                                    solo
                                    outlined
                                ></VTextField>
                                <VTextField
                                    v-model="matchPassword"
                                    placeholder="Repeat new password *"
                                    type="password"
                                    :rules="[
                                        rules.min,
                                        rules.max,
                                        confirmPassword
                                    ]"
                                    required
                                    solo
                                    outlined
                                ></VTextField>
                            </VCol>
                        </VRow>
                    </VContainer>
                    <small>*indicates required field</small>
                </VCardText>
                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn color="blue darken-1" @click="dialog = false"
                        >Save</VBtn
                    >
                    <VBtn color="primary" @click="updatePassword">Close</VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </VRow>
</template>

<script>
export default {
    name: 'LoginForm',
    data: () => ({
        password: 'password',
        newPassword: '',
        matchPassword: '',
        dialog: false,
        passwordRules: [],
        rules: {
            required: value => !!value || 'Required.',
            min: value => value.length >= 8 || 'Min 8 characters',
            max: value => value.length <= 255 || 'Max 255 characters'
        }
    }),

    computed: {
        confirmPassword() {
            return (
                this.newPassword === this.matchPassword ||
                "Password doesn't match confirmation"
            );
        }
    },

    methods: {
        updatePassword() {
            //TODO action to handle save password
            this.dialog = false;
        }
    }
};
</script>
