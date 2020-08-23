<template>
    <div>
        <VSubheader>{{ label }}</VSubheader>
        <LanguageSwitcher />
    </div>
</template>

<script>
import LanguageSwitcher from '../i18n/LanguageSwitcher';
export default {
    name: 'ProfileDisplayLanguage',
    components: { LanguageSwitcher },
    props: {
        label: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped></style>
