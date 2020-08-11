<template>
    <VApp>
        <VContainer fluid pa-0>
            <VRow no-gutters>
                <VCol class="primary-vcol" xl="6" lg="6" md="6" cols="12">
                    <VRow no-gutters justify="end">
                        <img
                            :src="
                                require('@/assets/auth/icon_circle_mark_normal.svg')
                            "
                            alt="icon in circle ok mark normal"
                            class="normal-ok-sign "
                        />
                    </VRow>
                    <VRow no-gutters justify="center">
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
                            <RouterLink :to="{ path: 'login' }">
                                <VRow no-gutters>
                                    <img
                                        :src="
                                            require('@/assets/auth/icon_circle_letter_s.svg')
                                        "
                                        alt="logo of schedulia"
                                        class="logo-image"
                                    />
                                    <h2 class="logo-text">
                                        {{ lang.SCHEDULIA }}
                                    </h2>
                                </VRow>
                            </RouterLink>
                            <VRow no-gutters>
                                <VCol class="place-for-form-vcol">
                                    <slot></slot>
                                </VCol>
                            </VRow>
                            <VRow></VRow>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
        </VContainer>
    </VApp>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
export default {
    name: 'LayoutMainPage',
    data: () => ({
        lang: enLang
    })
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
@media screen and (max-width: 960px) {
    .primary-vcol {
        order: 0;
        height: 80vmax;
    }
    .secondary-vcol {
        height: 80vmax;
    }
    .envelop-image {
        display: none;
    }
    .first-column-in-secondary {
        display: none;
    }
    .office-worker-image {
        margin-top: 10px;
        min-height: 50vmin;
    }
}
.place-for-form-vcol {
    margin-top: 150px;
}

.logo-image {
    height: 52px;
    width: 49px;
    margin-top: 16px;
}
.logo-text {
    margin-top: 24px;
    margin-left: 8px;
    font-weight: bold;
    color: var(--v-primary-base);
}
a {
    text-decoration: none;
}
.normal-ok-sign {
    height: 59px;
    width: 59px;
    z-index: 20;
    margin-top: 61px;
    margin-right: 67px;
}
.office-worker-image {
    height: 50vmin;
    min-height: 400px;
    margin-top: 80px;
}
.envelop-image {
    margin-top: 64px;
    margin-left: -46px;
}
.rotated-ok-image {
    height: 33px;
    width: 33px;
    z-index: 20;
    margin-left: 82px;
    margin-top: 600px;
}
</style>
