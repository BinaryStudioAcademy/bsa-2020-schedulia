<template>
    <VContainer class="container-content">
        <VRow>
            <VCol offset-md="3" md="6" lg="4" sm="12">
                <VForm>
                    <VContainer>
                        <VRow>
                            <VCol cols="12">
                                {{
                                    lang.YOU_LOG_IN_WITH_AN_EMAIL_ADDRESS_AND_PASSWORD
                                }}
                            </VCol>
                            <VCol cols="12">
                                <ProfileDisabledField
                                    :label="lang.EMAIL"
                                    :value="userProfile.email"
                                    :defaultValue="user.email"
                                />
                            </VCol>
                            <VCol cols="12">
                                <ProfileDisabledField
                                    :label="lang.PASSWORD"
                                    :value="password"
                                    :defaultValue="password"
                                />
                            </VCol>
                            <VCol>
                                <ChangePasswordForm />
                            </VCol>
                        </VRow>
                    </VContainer>
                </VForm>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';
import ChangePasswordForm from './ChangePasswordForm.vue';
import ProfileDisabledField from './ProfileDisabledField.vue';

export default {
    name: 'LoginForm',
    components: {
        ChangePasswordForm,
        ProfileDisabledField
    },
    data: () => ({
        userProfile: {
            email: null
        }
    }),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('auth', {
            user: 'getLoggedUser'
        }),

        password() {
            return '******';
        }
    }
};
</script>
