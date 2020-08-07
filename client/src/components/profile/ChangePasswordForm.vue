<template>
    <VRow justify="center">
        <VDialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <VBtn color="primary" dark v-bind="attrs" v-on="on">
                    {{ lang.CHANGE_PASSWORD }}
                </VBtn>
            </template>
            <VCard>
                <VCardTitle>
                    <span class="headline">{{ lang.CHANGE_PASSWORD }}</span>
                </VCardTitle>
                <VCardText>
                    <VContainer>
                        <VRow>
                            <VCol cols="12" v-if="errorMessage">
                                <div class="error has-text-danger" >{{ errorMessage }}</div>
                            </VCol>
                            <VCol cols="12">
                                <VSubheader>{{
                                    lang.CURRENT_PASSWORD
                                }}</VSubheader>
                                <VTextField
                                    v-model="password"
                                    :placeholder="lang.CURRENT_PASSWORD + ' *'"
                                    type="password"
                                    :rules="[required]"
                                    required
                                    solo
                                    outlined
                                ></VTextField>
                            </VCol>
                            <VCol cols="12">
                                <VSubheader>{{ lang.NEW_PASSWORD }}</VSubheader>
                                <VTextField
                                    v-model="newPassword"
                                    :placeholder="lang.NEW_PASSWORD + ' *'"
                                    type="password"
                                    :rules="[
                                        required,
                                        min,
                                        max,
                                        confirmPassword
                                    ]"
                                    required
                                    solo
                                    outlined
                                ></VTextField>
                                <VTextField
                                    v-model="matchPassword"
                                    :placeholder="
                                        lang.REPEAT_NEW_PASSWORD + ' *'
                                    "
                                    type="password"
                                    :rules="[
                                        required,
                                        min,
                                        max,
                                        confirmPassword
                                    ]"
                                    required
                                    solo
                                    outlined
                                ></VTextField>
                            </VCol>
                        </VRow>
                    </VContainer>
                    <small>* {{ lang.INDICATES_REQUIRED_FIELD }}</small>
                </VCardText>
                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn color="blue darken-1" @click="dialog = false">{{
                        lang.SAVE
                    }}</VBtn>
                    <VBtn color="primary" @click="updatePassword">{{
                        lang.CLOSE
                    }}</VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </VRow>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'LoginForm',
    data: () => ({
        lang: enLang,
        password: 'password',
        newPassword: '',
        matchPassword: '',
        dialog: false,
        errorMessage: '',
        rules: {
            min: 8,
            max: 255
        }
    }),

    methods: {
        confirmPassword() {
            return (
                this.newPassword === this.matchPassword ||
                this.lang.PASSWORD_DOESNT_MATCH
            );
        },
        required(value) {
            return !!value || this.lang.REQUIRED;
        },
        min(value, min = this.rules.min) {
            return (
                value.length >= min ||
                `${this.lang.MIN} ${min} ${this.lang.CHARACTERS.toLowerCase()}`
            );
        },
        max(value, max = this.rules.max) {
            return (
                value.length <= max ||
                `${
                    this.lang.MAX
                } ${max} ${this.lang.CHARACTERS.toLocaleLowerCase()}`
            );
        },

        async updatePassword() {
            try {

                this.dialog = false;
            } catch (error) {
                this.showErrorMessage(error.message);
            }
        }

        showErrorMessage(message) {
            this.errorMessage(message);
        }
    }
};
</script>
