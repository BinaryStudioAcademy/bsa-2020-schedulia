<template>
    <VContainer>
        <VRow class="rowHeight-70">
            <VCol class="secondary col-2"> </VCol>
            <VCol class="secondary col-4">
                <VRow align-="center" justify="start">
                    <img
                        :src="require('@/assets/auth/icon_circle_letter_s.svg')"
                        alt="logo of schedulia"
                        class="iconCircle"
                    />
                    <h2 class="primary--text ml-3 mt-1">
                        {{ lang.SCHEDULIA }}
                    </h2>
                </VRow>
            </VCol>
            <VCol class="primary col-6"> </VCol>
        </VRow>
        <VRow class="rowHeight-70">
            <VCol class="secondary col-6"></VCol>
            <VCol class="primary col-5"></VCol>
            <VCol class="primary col-1">
                <img
                    :src="require('@/assets/auth/icon_circle_mark_normal.svg')"
                    alt="icon in circle ok mark normal"
                    class="iconCircle-59"
                />
            </VCol>
        </VRow>
        <VRow>
            <VCol class="secondary col-2"></VCol>
            <VCol class="secondary col-4">
                <VRow class="mt-16">
                    <slot></slot>
                </VRow>
            </VCol>
            <VCol class="primary col-6">
                <VRow align="start" justify="center">
                    <Img
                        :src="require('@/assets/auth/office_worker.svg')"
                        alt="collage office employee at work"
                        class="mt-2 officeWorker"
                    />
                </VRow>
            </VCol>
        </VRow>
        <VRow class="rowHeight-200">
            <VCol class="secondary col-6">
                <VRow align="start" justify="space-between">
                    <img
                        :src="
                            require('@/assets/auth/icon_circle_mark_rotated.svg')
                        "
                        class="mt-n16 ml-16 iconCircle-33"
                    />
                    <img
                        :src="require('@/assets/auth/icon_circle_mail.svg')"
                        class="mr-n7 mt-8 iconCircle-75"
                    />
                </VRow>
            </VCol>
            <VCol class="primary col-6"> </VCol>
        </VRow>
    </VContainer>
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
.iconCircle-75 {
    height: 75px;
    width: 75px;
    z-index: 20;
}
.iconCircle-33 {
    height: 33px;
    width: 33px;
    z-index: 20;
}
.iconCircle-59 {
    height: 59px;
    width: 59px;
    z-index: 20;
}
.officeWorker {
    height: 565px;
    width: 464px;
}
.rowHeight-70 {
    height: 70px;
}
.rowHeight-200 {
    height: 200px;
}
</style>
