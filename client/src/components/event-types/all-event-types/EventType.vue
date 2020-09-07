<template>
    <div
        class="event-type-block"
        :class="{ 'disabled-event': isDisabled }"
        :style="{ 'border-bottom': '18px solid ' + borderColor }"
    >
        <div class="action-button text-right">
            <DropDown :select-event-type="eventType" />
        </div>
        <div class="event-type-main">
            <div class="event-type-content">
                <h3 class="event-type-name">{{ eventType.name }}</h3>
                <span class="event-type-about"
                    >{{ eventType.duration }} {{ lang.MINS }}</span
                >
                <span
                    class="d-block mt-3 internal-note"
                    v-if="eventType.internalNote"
                    ><i>"{{ eventType.internalNote }}"</i></span
                >
            </div>
        </div>
        <input
            style="opacity: 0;position: absolute"
            type="text"
            :value="publicLink"
            :id="'publicLinkInp-' + eventType.id"
        />
        <div class="event-type-invitee mb-2">
            <Avatar :size="24" :color="'black'"></Avatar>
        </div>
        <VDivider />
        <VRow class="event-type-actions">
            <VCol class="duration text-left" cols="4">
                <span v-if="isDisabled">
                    <span>/{{ eventType.slug }}</span>
                </span>
                <RouterLink
                    v-else
                    :to="{
                        path: `/${eventType.owner.nickname}/${eventType.id}`
                    }"
                >
                    /{{ eventType.slug }}
                </RouterLink>
            </VCol>
            <VCol class="text-right" cols="8">
                <VBtn
                    class="ma-2"
                    outlined
                    small
                    :color="eventType.color"
                    :disabled="isDisabled"
                    @click="onCopyLink"
                >
                    {{ lang.COPY_LINK }}
                    <VIcon right dark>mdi-vector-arrange-below</VIcon>
                </VBtn>
            </VCol>
        </VRow>
        <Alert
            :type="alert.type"
            :message="alert.message"
            :visibility="alert.visibility"
        />
    </div>
</template>

<script>
import DropDown from '@/components/event-types/all-event-types/DropDown';
import Avatar from '@/components/common/Avatar/Avatar';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';
import Alert from '@/components/alert/Alert';

export default {
    name: 'EventType',
    data: () => ({
        alert: {
            type: '',
            message: '',
            visibility: false
        }
    }),
    props: {
        eventType: {
            required: true
        }
    },
    components: {
        DropDown,
        Avatar,
        Alert
    },
    methods: {
        onCopyLink() {
            const publicLinkInp = document.getElementById(
                'publicLinkInp-' + this.eventType.id
            );
            publicLinkInp.select();
            document.execCommand('copy');
            this.alert.visibility = true;
            this.alert.type = 'success';
            this.alert.message = this.lang.PUBLIC_LINK_WAS_COPIED;
            setTimeout(() => {
                this.alert.visibility = false;
            }, 1500);
        }
    },
    computed: {
        publicLink() {
            const domain = window.location.hostname;
            return (
                domain +
                '/' +
                this.eventType.owner.nickname +
                '/' +
                this.eventType.id
            );
        },
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        isDisabled() {
            return this.eventType.disabled;
        },
        borderColor() {
            if (this.isDisabled) {
                return '#e5e5e5';
            }
            return this.eventType.color;
        }
    }
};
</script>

<style scoped>
.event-type-main {
    min-height: 100px;
}
.event-type-name {
    word-break: break-all;
}
.event-type-block {
    background: #fff;
    padding: 15px 20px 0 20px;
    border-radius: 10px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.25);
    height: 100%;
}
.event-type-block div {
    cursor: pointer;
}
.event-type-about {
    color: #858585;
}
.headline {
    font-size: 12px !important;
}
.duration {
    display: flex;
    justify-content: center;
    align-items: center;
}
.duration a,
.duration span {
    color: var(--v-primary-base);
    font-size: 16px;
    text-decoration: none;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.disabled-event {
    user-select: none;
}
.disabled-event .event-type-content h3,
.disabled-event .event-type-about,
.disabled-event .event-type-actions .duration span,
.disabled-event span.internal-note {
    color: #e5e5e5;
}
.internal-note {
    color: gray;
    font-size: 14px;
}
</style>
