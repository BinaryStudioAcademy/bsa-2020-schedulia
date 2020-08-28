<template>
    <VForm class="mt-9 mb-16" ref="form">
        <div class="mb-2">
            <label>{{ lang.EVENT_NAME_LABEL }}*</label>
        </div>

        <VTextField
            :value="data.name"
            @input="changeEventTypeProperty('name', $event)"
            :rules="nameRules"
            outlined
            class="app-textfield"
            dense
        >
        </VTextField>

        <div class="mb-2">
            <label>{{ lang.LOCATION_LABEL }}</label>
        </div>

        <VSelect
            :value="data.location"
            :items="items"
            @change="changeEventTypeProperty('location', $event)"
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
            :value="data.description"
            @change="changeEventTypeProperty('description', $event)"
            :rules="descRules"
            placeholder="Placeholder"
            outlined
            class="mb-3"
        >
        </VTextarea>

        <div class="mb-2">
            <label>{{ lang.EVENT_LINK_LABEL }}*</label>
        </div>

        <VTextField
            :rules="eventLinkRules"
            outlined
            :value="data.slug"
            @input="changeEventTypeProperty('slug', $event)"
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
                        v-on:click="changeEventTypeProperty('color', id)"
                    >
                        <VOverlay
                            absolute
                            :value="data.color === id"
                            class="rounded-circle"
                            color="eventColor"
                        >
                            <img
                                :src="require('@/assets/images/icon_check.png')"
                                alt=""
                            />
                        </VOverlay>
                    </VImg>
                </div>
            </VRow>
        </div>
        <div>
            <VBtn text outlined width="114" class="mr-3" :to="{ name: 'EventTypes' }">
                {{ lang.CANCEL }}
            </VBtn>
            <VBtn
                @click="clickNext"
                color="primary"
                class="white--text"
                width="114"
            >
                {{ lang.NEXT }}
            </VBtn>
        </div>
    </VForm>
</template>

<script>
import { mapActions } from 'vuex';
import * as actionEventType from "@/store/modules/eventType/types/actions";
import eventTypeMixin from "@/components/events/eventTypeMixin";

export default {
    name: 'CreateEventTypeForm',
    mixins: [eventTypeMixin],
    props: {
        isBooking: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            items: ['address on the map', 'zoom', 'skype'],
            colors: ['yellow', 'red', 'blue', 'green'],
            nameRules: [
                v => !!v || this.lang.PROVIDE_EVENT_NAME,
                v =>
                    v.length >= 2 ||
                    this.lang.EVENT_NAME_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_MORE_THAN_VALUE.replace(
                            'value',
                            2
                        ),
                v =>
                    v.length <= 55 ||
                    this.lang.EVENT_NAME_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            55
                        )
            ],
            eventLinkRules: [
                v => !!v || this.lang.PROVIDE_EVENT_LINK,
                v =>
                    v.length <= 250 ||
                    this.lang.EVENT_LINK_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            250
                        ),
                v =>
                    /[a-z]|[0-9]|-|_/.test(v) ||
                    this.lang.EVENT_LINK_VALID_SYMBOLS
            ],
            descRules: [
                v =>
                    v.length <= 1000 ||
                    this.lang.DESCRIPTION_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            1000
                        )
            ]
        };
    },

    methods: {
        ...mapActions('eventType', {
            setEventType: actionEventType.SET_EVENT_TYPE
        }),
        clickNext() {
            if (this.$refs.form.validate()) {
                if (this.isBooking) {
                    this.$emit('changePanel');
                } else {
                    this.$router.push({name: 'new-event-edit'});
                }
            }
        },
        getSlug(value) {
            return value.replace(/\s/g, '-');
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

.app-textfield.error--text::v-deep .v-input__slot {
    background-color: var(--v-validationError-base);
}

.image-circle {
    cursor: pointer;
}

.image-circle:hover {
    opacity: 0.9;
}
</style>
