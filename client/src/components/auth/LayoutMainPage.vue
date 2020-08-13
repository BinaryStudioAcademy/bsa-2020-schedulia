<template>
    <VApp>
        <VContainer fluid pa-0>
            <VRow no-gutters>
                <VCol class="primary-vcol" xl="6" lg="6" md="6" cols="12">
                    <div class="logo-primary-div">
                        <RouterLink :to="{ name: 'SignIn' }">
                            <VRow no-gutters align="center" justify="center">
                                <img
                                    :src="
                                        require('@/assets/auth/icon_circle_letter_s.svg')
                                    "
                                    alt="logo of schedulia"
                                    class="logo-image"
                                />
                                <h5 class="logo-h5 secondary--text">
                                    {{ lang.SCHEDULIA }}
                                </h5>
                            </VRow>
                        </RouterLink>
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
                            <div class="logo-secondary-div ">
                                <RouterLink :to="{ name: 'SignIn' }">
                                    <VRow no-gutters align="center">
                                        <img
                                            :src="
                                                require('@/assets/auth/icon_circle_letter_s.svg')
                                            "
                                            alt="logo of schedulia"
                                            class="logo-image"
                                        />
                                        <h5 class="logo-h5 ">
                                            {{ lang.SCHEDULIA }}
                                        </h5>
                                    </VRow>
                                </RouterLink>
                            </div>
                            <VRow no-gutters justify="start" align="start">
                                <VCol class="place-for-form-vcol">
                                    <slot></slot>
                                </VCol>
                            </VRow>
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
    font-size: 10px;
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
    margin-top: 15vh;
}
.logo-secondary-div {
    margin-top: 1.7vh;
}
.logo-primary-div {
    display: none;
    margin-top: 1.7vh;
}

@media screen and (max-width: 960px) {
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
    .office-worker-image {
        margin-top: 5vmin;
        min-height: 50vmin;
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
    height: 50vmin;
    min-height: 200px;
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
    font-size: 2.4rem;
    line-height: 3.6rem;
}
.logo-h5 {
    margin-left: 0.8rem;
    color: var(--v-primary-base);
}
a {
    text-decoration: none;
}
</style>
