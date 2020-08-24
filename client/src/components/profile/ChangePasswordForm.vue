<template>
    <VRow>
        <VDialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                    class="ma-2"
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
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
                            <VAlert cols="12" type="error" v-if="errorMessage">
                                {{ errorMessage }}
                            </VAlert>
                            <VCol cols="12">
                                <VSubheader
                                    >{{ lang.CURRENT_PASSWORD }}
                                </VSubheader>
                                <VTextField
                                    v-model="password"
                                    :placeholder="lang.CURRENT_PASSWORD + ' *'"
                                    :rules="[required]"
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-icon="
                                        showPassword ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                                    @click:append="showPassword = !showPassword"
                                    required
                                    dense
                                    outlined
                                ></VTextField>
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
                                    dense
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
                                    dense
                                    outlined
                                ></VTextField>
                            </VCol>
                        </VRow>
                    </VContainer>
                    <small>* {{ lang.INDICATES_REQUIRED_FIELD }}</small>
                </VCardText>
                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn
                        color="primary"
                        :disabled="!validateForm"
                        @click="update"
                        >{{ lang.SAVE }}
                    </VBtn>
                    <VBtn
                        class="text cancel v-btn--flat v-btn--outlined"
                        @click="dialog = false"
                        >{{ lang.CLOSE }}
                    </VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </VRow>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'LoginForm',
    data: () => ({
        password: '',
        newPassword: '',
        matchPassword: '',
        dialog: false,
        showPassword: false,
        errorMessage: '',
        rules: {
            min: 8,
            max: 255
        }
    }),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        validateForm() {
            return (
                this.confirmPassword() === true &&
                this.min(this.newPassword) === true &&
                this.max(this.newPassword) === true
            );
        }
    },

    methods: {
        ...mapActions('profile', ['updatePassword']),

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

        async update() {
            try {
                if (this.validateForm) {
                    await this.updatePassword({
                        password: this.newPassword,
                        oldPassword: this.password
                    });
                    this.dialog = false;
                } else {
                    this.showErrorMessage(
                        this.lang.PLEASE_FILL_ALL_FORM_FIELDS
                    );
                }
            } catch (error) {
                this.showErrorMessage(error.message);
            }
        },

        showErrorMessage(message) {
            this.errorMessage = message;
        }
    }
};
</script>

<style lang="scss" scoped>
.v-btn {
    font-size: 13px;
    text-transform: none;

    &.cancel {
        border-color: rgba(0, 0, 0, 0.12);
        background: none;
        box-shadow: none;
    }
}

.v-subheader {
    padding: 0;
    color: #2c2c2c;
    font-size: 13px;
    line-height: 16px;
}
</style>
