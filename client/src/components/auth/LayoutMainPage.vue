<template>
    <VContainer fluid pa-0>
        <VRow no-gutters>
            <VCol class="primary-vcol" xl="6" lg="6" md="6" cols="12">
                <div class="logo-primary-div">
                    <VRow no-gutters align="center" justify="center">
                        <RouterLink :to="{ name: 'SignIn' }">
                            <img
                                :src="
                                    require('@/assets/auth/icon_circle_letter_s.svg')
                                "
                                alt="logo of schedulia"
                                class="logo-image"
                            />
                        </RouterLink>
                        <RouterLink :to="{ name: 'SignIn' }">
                            <h5 class="logo-h5 secondary--text">
                                {{ lang.SCHEDULIA }}
                            </h5>
                        </RouterLink>
                    </VRow>
                </div>
                <VRow no-gutters justify="end">
                    <img
                        :src="
                            require('@/assets/auth/icon_circle_mark_normal.svg')
                        "
                        alt="icon in circle ok mark normal"
                        class="normal-ok-image "
                    />
                </VRow>
                <VRow no-gutters justify="center" align="end">
                    <Img
                        :src="require('@/assets/auth/office_worker.png')"
                        alt="collage office employee at work"
                        class="office-worker-image"
                    />
                </VRow>
                <VRow no-gutters justify="start">
                    <img
                        :src="require('@/assets/auth/icon_circle_mail.svg')"
                        alt="envelop sign"
                        class="envelop-image"
                    />
                </VRow>
            </VCol>
            <VCol class="secondary-vcol " xl="6" lg="6" md="6" cols="12">
                <VRow no-gutters justify="end">
                    <VCol
                        class="first-column-in-secondary"
                        xl="4"
                        lg="4"
                        md="4"
                        cols="1"
                    >
                        <img
                            :src="
                                require('@/assets/auth/icon_circle_mark_rotated.svg')
                            "
                            alt="rotated ok sign"
                            class="rotated-ok-image "
                        />
                    </VCol>
                    <VCol
                        class="second-column-in-secondary"
                        xl="8"
                        lg="8"
                        md="8"
                        cols="11"
                    >
                        <div class="logo-secondary-div ">
                            <VRow no-gutters align="center">
                                <RouterLink :to="{ name: 'SignIn' }">
                                    <img
                                        :src="
                                            require('@/assets/auth/icon_circle_letter_s.svg')
                                        "
                                        alt="logo of schedulia"
                                        class="logo-image"
                                    />
                                </RouterLink>
                                <RouterLink :to="{ name: 'SignIn' }">
                                    <h5 class="logo-h5 ">
                                        {{ lang.SCHEDULIA }}
                                    </h5>
                                </RouterLink>
                            </VRow>
                        </div>
                        <VRow no-gutters justify="start" align="start">
                            <VCol class="place-for-form-vcol">
                                <slot></slot>
                            </VCol>
                        </VRow>
                        <VCol cols="12" class="pa-0">
                            <VRow
                                no-gutters
                                justify="space-between"
                                align="baseline"
                            >
                                <VCol cols="6">
                                    <span class="info-text">
                                        {{
                                            lang.YOU_CAN_CHANGE_LANGUAGE_TO
                                        }}</span
                                    >
                                </VCol>
                                <VCol cols="5">
                                    <LanguageSwitcher />
                                </VCol>
                                <VCol cols="1"> </VCol>
                            </VRow>
                        </VCol>
                    </VCol>
                </VRow>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import LanguageSwitcher from '../i18n/LanguageSwitcher';

import { mapGetters } from 'vuex';
export default {
    name: 'LayoutMainPage',
    data: () => ({}),
    components: { LanguageSwitcher },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>
<style>
html {
    overflow-y: auto !important;
}
</style>
<style scoped>
.secondary-vcol {
    height: 100vh;
    background-color: var(--v-secondary-base);
}
.primary-vcol {
    height: 100vh;
    order: 2;
    background-color: var(--v-primary-base);
}
.first-column-in-secondary {
    height: 100vh;
}
.second-column-in-secondary {
    width: 100%;
}
.place-for-form-vcol {
    margin-top: 13vh;
}
.logo-secondary-div {
    margin-top: 1.7vh;
}
.logo-primary-div {
    display: none;
    margin-top: 1.7vh;
}
.info-text {
    color: var(--v-info-base);
}

@media screen and (max-width: 959px) {
    .primary-vcol {
        order: 0;
        height: 100vh;
    }
    .secondary-vcol {
        height: 100vh;
    }
    .envelop-image {
        display: none;
    }
    .normal-ok-image {
        display: none;
    }
    .first-column-in-secondary {
        display: none;
    }
    img.office-worker-image {
        width: 95vmin;
        margin-top: 10vh;
    }
    .logo-primary-div {
        display: block;
    }
    .logo-secondary-div {
        display: none;
    }
    .place-for-form-vcol {
        margin-top: 9vh;
    }
}
.logo-image {
    height: 52px;
    width: 49px;
}
.normal-ok-image {
    height: 6.3vh;
    min-height: 30px;
    z-index: 20;
    margin-top: 6.6vh;
    margin-right: 3.6vw;
}
.office-worker-image {
    width: 60vmin;
    margin-top: 8.6vh;
}
.envelop-image {
    margin-top: 7vh;
    margin-left: -46px;
    z-index: 20;
}
.rotated-ok-image {
    height: 33px;
    width: 33px;
    z-index: 20;
    margin-left: 4vw;
    margin-top: 65vh;
}
h5 {
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 36px;
}
.logo-h5 {
    margin-left: 8px;
    color: var(--v-primary-base);
}
a {
    text-decoration: none;
}
</style>
