<template>
    <VContainer>
        <VCard class="mt-7">
            <VRow align="center">
                <VCol cols="1">
                    <div>
                        <img
                            :src="colorById[color].image"
                            alt=""
                            class="ml-10"
                        />
                    </div>
                </VCol>
                <VCol>
                    <div>
                        <VCardTitle>
                            {{ lang.CREATE_EVENT_TYPE_TITLE }}
                        </VCardTitle>
                        <VCardSubtitle>
                            {{ lang.CREATE_EVENT_TYPE_SUBTITLE }}
                        </VCardSubtitle>
                    </div>
                </VCol>
            </VRow>
            <VDivider class="mx-4"></VDivider>
            <VRow>
                <VCol cols="6" offset-md="2">
                    <VForm class="mt-9 mb-16">
                        <div class="mb-2">
                            <label>{{ lang.EVENT_NAME_LABEL }}</label>
                        </div>

                        <VTextField
                            v-model="eventName"
                            :rules="nameRules"
                            outlined
                            class="app-textfield"
                            value=""
                            dense
                        >
                        </VTextField>

                        <div class="mb-2">
                            <label>{{ lang.LOCATION_LABEL }}</label>
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
                            <label>{{ lang.DESCRIPTION_LABEL }}</label>
                        </div>

                        <VTextarea
                            v-model="description"
                            :rules="descRules"
                            placeholder="Placeholder"
                            outlined
                            class="mb-3"
                        >
                        </VTextarea>

                        <div class="mb-2">
                            <label>{{ lang.EVENT_LINK_LABEL }}</label>
                        </div>

                        <VTextField
                            :rules="eventLinkRules"
                            outlined
                            :value="eventLinkDashed"
                            dense
                            class="mb-4 app-textfield"
                            required
                        >
                        </VTextField>

                        <div class="mb-2">
                            <p>{{ lang.EVENT_COLOR_LABEL }}</p>
                        </div>
                        <div class="mb-12">
                            <VRow>
                                <div class="d-flex">
                                    <VImg
                                        v-for="id in colors"
                                        :key="id"
                                        :src="colorById[id].image"
                                        alt=""
                                        class="mr-7 ml-3 image-circle"
                                        v-on:click="setColor(id)"
                                    >
                                        <VOverlay absolute :value="color === id" class="rounded-circle" color="eventColor">
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
                                {{ lang.CANCEL }}
                            </VBtn>
                            <VBtn
                                color="primary"
                                class="white--text"
                                width="114"
                            >
                                {{ lang.NEXT }}
                            </VBtn>
                        </div>
                    </VForm>
                </VCol>
            </VRow>
        </VCard>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
export default {
    name: 'CreateEventTypeForm',
    data() {
        return {
            lang: enLang,
            eventName: '',
            eventLink: '',
            selected: '',
            description: '',
            items: ['address on the map', 'zoom', 'skype'],
            color: 'yellow',
            colorById: {
                yellow: {
                    id: 'yellow',
                    image: require('@/assets/images/yellow_circle.png')
                },
                red: {
                    id: 'red',
                    image: require('@/assets/images/red_circle.png')
                },
                blue: {
                    id: 'blue',
                    image: require('@/assets/images/blue_circle.png')
                },
                green: {
                    id: 'green',
                    image: require('@/assets/images/green_circle.png')
                }
            },
            colors: ['yellow', 'red', 'blue', 'green'],
            nameRules: [
                v => !!v || this.lang.PROVIDE_EVENT_NAME,
                v => v.length >= 2 || this.lang.EVENT_NAME_LABEL +' '+ this.lang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 2),
                v => v.length <= 55 || this.lang.EVENT_NAME_LABEL +' '+ this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 55),
            ],
            eventLinkRules: [
                v => !!v || this.lang.PROVIDE_EVENT_LINK,
                v => v.length <= 250 || this.lang.EVENT_LINK_LABEL +' '+ this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 250),
                v => /[a-z]|[0-9]|-|_/.test(v) || this.lang.EVENT_LINK_VALID_SYMBOLS
            ],
            descRules: [
                v => v.length <= 1000 || this.lang.DESCRIPTION_LABEL +' '+ this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 1000)
            ]
        };
    },

    computed: {
        eventLinkDashed() {
            return this.eventName.replace(/\s/g, '-');
        }
    },

    methods: {
        setColor(id) {
            this.color = this.colorById[id].id;
        },
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

.app-textfield.error--text::v-deep .v-input__slot
{
    background-color: var(--v-validationError-base);
}

.image-circle{
    cursor: pointer;
}

.image-circle:hover{
    opacity: 0.9;
}
</style>
