<template>
    <VApp>
        <VContainer>
            <VRow no-gutters="true">
                <VCol class="main-parts secondary">
                    <VRow no-gutters="true">
                        <VCol class="col-4 first-column">
                            <img
                                :src="
                                    require('@/assets/auth/icon_circle_mark_rotated.svg')
                                "
                                alt="rotated ok sign"
                                class="rotated-ok-image "
                            />
                        </VCol>
                        <VCol class="col-8 second-column">
                            <VRow no-gutters="true">
                                <img
                                    :src="
                                        require('@/assets/auth/icon_circle_letter_s.svg')
                                    "
                                    alt="logo of schedulia"
                                    class="logo-image"
                                />
                                <h2 class="primary--text logo-text">
                                    {{ lang.SCHEDULIA }}
                                </h2>
                            </VRow>
                            <VRow no-gutters="true">
                                <VCol class="place-for-form-vcol">
                                    <slot></slot>
                                </VCol>
                            </VRow>
                            <VRow></VRow>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol class="main-parts primary">
                    <VRow no-gutters="true" justify="end">
                        <img
                            :src="
                                require('@/assets/auth/icon_circle_mark_normal.svg')
                            "
                            alt="icon in circle ok mark normal"
                            class="normal-ok-sign "
                        />
                    </VRow>
                    <VRow no-gutters="true">
                        <Img
                            :src="require('@/assets/auth/office_worker.png')"
                            alt="collage office employee at work"
                            class="office-worker-image"
                        />
                    </VRow>
                    <VRow>
                        <img
                            :src="require('@/assets/auth/icon_circle_mail.svg')"
                            alt="envelop sign"
                            class="envelop-image"
                        />
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

<style scoped>
.main-parts {
    height: 930px;
    width: 948px;
}
.first-column {
    height: 930px;
}
.second-column {
    height: 930px;
    width: 100%;
}
.logo-image {
    height: 52px;
    width: 49px;
    margin-top: 16px;
}
.logo-text {
    margin-top: 24px;
    margin-left: 8px;
}
.rotated-ok-image {
    height: 33px;
    width: 33px;
    z-index: 20;
    margin-left: 82px;
    margin-top: 599px;
}
.place-for-form-vcol {
    margin-top: 189px;
}
.normal-ok-sign {
    height: 59px;
    width: 59px;
    z-index: 20;
    margin-top: 61px;
    margin-right: 67px;
}

.office-worker-image {
    height: 464px;
    margin-top: 80px;
    margin-left: 200px;
}
.envelop-image {
    margin-top: 64px;
    margin-left: -30px;
}
</style>
