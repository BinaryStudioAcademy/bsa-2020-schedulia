<template>
    <VContainer>
        <VCard class="mt-7" height="1000">
            <VRow>
                <VCol cols="12">
                    <VRow align="center">
                        <div>
                            <img
                                :src="imageUrl ? imageUrl : require('@/assets/images/blue_circle.png')"
                                alt=""
                                class="ml-10"
                            />
                        </div>
                        <div>
                            <VCardTitle>
                                What even is this?
                            </VCardTitle>
                            <VCardSubtitle>
                                Sales manager
                            </VCardSubtitle>
                        </div>
                    </VRow>
                </VCol>
                <VDivider class="mx-4"></VDivider>
                <VCol cols="12">
                    <VRow>
                        <VCol cols="6" offset-md="2">
                            <VForm class="mt-9">
                                <div class="mb-2">
                                    <label>Event Name</label>
                                </div>

                                <VTextField
                                    class="app-combobox"
                                    v-model="eventName"
                                    :rules="nameRules"
                                    placeholder="Placeholder"
                                    outlined
                                    value="Sales Manager"
                                    dense
                                >
                                </VTextField>

                                <div class="mb-2">
                                    <label>Location</label>
                                </div>

                                <VSelect
                                    v-model="selected"
                                    :items="items"
                                    outlined
                                    placeholder="Option"
                                    dense
                                    class="mb-3"
                                >
                                </VSelect>

                                <div class="mb-2">
                                    <label>Description/Instructions</label>
                                </div>

                                <VTextarea
                                    v-model="description"
                                    :rules="descRules"
                                    outlined
                                    placeholder="Placeholder"
                                    class="mb-3"
                                >
                                </VTextarea>

                                <div class="mb-2">
                                    <label>Event Link</label>
                                </div>

                                <VTextField
                                    v-model="eventLink"
                                    :rules="eventLinkRules"
                                    placeholder="Placeholder"
                                    outlined
                                    value="Value"
                                    dense
                                    class="mb-4"
                                >
                                </VTextField>

                                <div class="mb-2">
                                    <p>Event Color</p>
                                </div>
                                <div class="mb-12">
                                    <VRow>
                                        <div class="d-flex">
                                            <VImg
                                                :src="require('@/assets/images/yellow_circle.png')"
                                                alt=""
                                                class="mr-7 ml-3"
                                                v-on:click="changeYellowCircle('yellow_circle.png')"
                                            >
                                                <VOverlay absolute :value="overlay1" class="rounded-circle" color="#18A0FB">
                                                    <img :src="require('@/assets/images/icon_check.png')" alt="">
                                                </VOverlay>
                                            </VImg>

                                            <VImg
                                                :src="require('@/assets/images/blue_circle.png')"
                                                alt=""
                                                class="mr-7"
                                                v-on:click="changeBlueCircle('blue_circle.png')"
                                            >
                                                <VOverlay absolute :value="overlay2" class="rounded-circle" color="#18A0FB">
                                                    <img :src="require('@/assets/images/icon_check.png')" alt="">
                                                </VOverlay>
                                            </VImg>

                                            <VImg
                                                :src="require('@/assets/images/red_circle.png')"
                                                alt=""
                                                class="mr-7"
                                                v-on:click="changeRedCircle('red_circle.png')"
                                            >
                                                <VOverlay absolute :value="overlay3" class="rounded-circle" color="#18A0FB">
                                                    <img :src="require('@/assets/images/icon_check.png')" alt="">
                                                </VOverlay>
                                            </VImg>
                                            <VImg
                                                :src="require('@/assets/images/green_circle.png')"
                                                alt=""
                                                class="mr-7"
                                                v-on:click="changeGreenCircle('green_circle.png')"
                                            >
                                                <VOverlay absolute :value="overlay4" class="rounded-circle" color="#18A0FB">
                                                    <img :src="require('@/assets/images/icon_check.png')" alt="">
                                                </VOverlay>
                                            </VImg>
                                        </div>
                                    </VRow>
                                </div>
                                <div>
                                    <VBtn
                                        text
                                        outlined
                                        width="114"
                                        class="mr-3"
                                    >
                                        Cancel
                                    </VBtn>
                                    <VBtn
                                        color="#281AC8"
                                        class="white--text"
                                        width="114"
                                    >
                                        Next
                                    </VBtn>
                                </div>
                            </VForm>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
        </VCard>
    </VContainer>
</template>

<script>
export default {
    name: 'NewEventTypeCard',
    data() {
        return {
            eventName: '',
            selected: '',
            description: '',
            eventLink: '',
            imageUrl: '',
            items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
            overlay1: false,
            overlay2: false,
            overlay3: false,
            overlay4: false,
            nameRules: [
                v => !!v || 'Please provide an event name',
                v => v.length >= 2 || 'Event name must be more than 2 characters',
                v => v.length <= 55 || 'Event name must be less than 55 characters'
            ],
            eventLinkRules: [
                v => !!v || 'Please provide an event link',
                v => v.length < 250 || 'Event link must be less than 250 characters'
            ],
            descRules: [
                v => v.length < 1000 || 'Description must be less than 1000 characters'
            ]
        };
    },

    methods: {
        changeYellowCircle($image) {
            this.overlay1 = !this.overlay1;
            this.overlay2 = false;
            this.overlay3 = false;
            this.overlay4 = false;
            this.imageUrl = require('@/assets/images/' + $image);
        },

        changeBlueCircle($image) {
            this.overlay2 = !this.overlay2;
            this.overlay1 = false;
            this.overlay3 = false;
            this.overlay4 = false;
            this.imageUrl = require('@/assets/images/' + $image);
        },

        changeRedCircle($image) {
            this.overlay3 = !this.overlay3;
            this.overlay1 = false;
            this.overlay2 = false;
            this.overlay4 = false;
            this.imageUrl = require('@/assets/images/' + $image);
        },

        changeGreenCircle($image) {
            this.overlay4 = !this.overlay4;
            this.overlay1 = false;
            this.overlay2 = false;
            this.overlay3 = false;
            this.imageUrl = require('@/assets/images/' + $image);
        }
    }
};
</script>

<style scoped>
.v-text-field {
    width: 506px;
}
.v-btn {
    font-size: 13px;
    text-transform: none;
}

.app-combobox.error--text,
.app-combobox .error--text {
    background-color: #FFE9E9;
}
</style>
