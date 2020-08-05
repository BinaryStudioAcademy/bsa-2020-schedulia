<template>
    <VApp>
        <VAppBar app color="primary" dark>
            <div class="d-flex align-center">
                <VImg
                    alt="Vuetify Logo"
                    class="shrink mr-2"
                    contain
                    src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
                    transition="scale-transition"
                    width="40"
                />

                <VImg
                    alt="Vuetify Name"
                    class="shrink mt-1 hidden-sm-and-down"
                    contain
                    min-width="100"
                    src="https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png"
                    width="100"
                />
            </div>

            <VSpacer></VSpacer>

            <VBtn
                href="https://github.com/vuetifyjs/vuetify/releases/latest"
                target="_blank"
                text
            >
                <span class="mr-2">Latest Release</span>
                <VIcon>mdi-open-in-new</VIcon>
            </VBtn>
        </VAppBar>

        <VMain>
            <VContainer>
                <VRow>
                    <VCol class="text-center">
                        <RouterLink to="/">Home</RouterLink>
                    </VCol>
                    <VCol class="text-center">
                        <RouterLink to="/about">About</RouterLink>
                    </VCol>
                    <VCol class="text-center">
                        <RouterLink to="/status">Status</RouterLink>
                    </VCol>
                    <VCol class="text-center">
                        <RouterLink :to="{name: 'profile'}">Profile</RouterLink>
                    </VCol>
                </VRow>
            </VContainer>
            <RouterView />
        </VMain>
    </VApp>
</template>

<script>
export default {
    name: 'App'
};
</script>
