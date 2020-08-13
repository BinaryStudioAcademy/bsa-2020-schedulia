<template>
    <div class="text-center pt-5">
        <h3>
            {{ lang.YOU_DONT_HAVE_ANY_EVENT_TYPES }}
        </h3>
        <br />
        <p>
            {{ lang.YOU_WILL_WANT_TO_ADD_EVENT_TYPE }}
        </p>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
export default {
    name: 'NoEventTypes',
    data: () => ({
        lang: enLang
    })
};
</script>

<style scoped></style>
