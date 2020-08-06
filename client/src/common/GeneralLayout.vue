<template>
    <VCard>
        <VAppBar color="deep-purple accent-4" dark height="90">
            <VContainer>
                <VRow>
                    <VCol class="text-left">
                        <VToolbarTitle>Page title</VToolbarTitle>
                    </VCol>
                    <VCol class="text-right">
                        <VBtn icon>
                            <VIcon>mdi-heart</VIcon>
                        </VBtn>
                    </VCol>
                </VRow>
            </VContainer>
        </VAppBar>
        <VAppBar color="white" dark> </VAppBar>
    </VCard>
</template>

<script>
export default {
    name: 'GeneralLayout'
};
</script>
