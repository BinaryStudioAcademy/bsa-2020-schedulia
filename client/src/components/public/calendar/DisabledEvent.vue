<template>
    <div class="disabled-event-conteiner">
        <h1>{{ lang.SORRY_THIS_EVENT_IS_DISABLED }}</h1>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'DisabledEvent',
    data: () => ({
        lang: enLang
    })
};
</script>

<style scoped>
.disabled-event-conteiner {
    min-height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.disabled-event-conteiner h1 {
    display: inline;
    color: grey;
}
</style>
