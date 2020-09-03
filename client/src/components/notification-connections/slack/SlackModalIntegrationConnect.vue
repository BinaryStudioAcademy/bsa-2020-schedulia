<template>
    <VDialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on, attrs }">
            <VBtn
                color="green"
                class="mr-3 slack-connect"
                v-bind="attrs"
                v-on="on"
                @click="updSlackData"
            >
                <VIcon color="white">mdi-plus</VIcon>
            </VBtn>
        </template>
        <VCard>
            <VCardTitle>
                <span class="headline">{{ lang.CONNECT_SLACK }}</span>
            </VCardTitle>
            <VCardText>
                <span class="subtitle-2">{{ lang.INCOMING_WEBHOOK }}</span>
                <VListItem>
                    <VListItemContent>
                        <VListItemTitle
                            >Add
                            <a
                                href="https://slack.com/apps/A0F7XDUAZ-incoming-webhooks"
                                target="_blank"
                            >
                                {{ lang.INCOMING_WEBHOOK }}
                            </a>
                            {{ lang.TO_YOUR }} <b>Slack</b> {{ lang.WORKSPACE }}.</VListItemTitle
                        >
                    </VListItemContent>
                </VListItem>

                <VListItem>
                    <VListItemContent>
                        <VListItemTitle
                            >{{ lang.PAST }} <b>{{ lang.INCOMING_WEBHOOK }}</b>
                            {{ lang.IN_THE_FIELD }}:</VListItemTitle
                        >
                    </VListItemContent>
                </VListItem>
                <VTextField dense solo outlined v-model="slackData.webhook">
                </VTextField>

                <span class="subtitle-2">{{ lang.CHANNEL_NAME }}/span>
                <VTextField
                    dense
                    solo
                    outlined
                    prepend-inner-icon="mdi-plus"
                    v-model="slackData.channel_name"
                >
                </VTextField>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >{{ lang.CLOSE }}</VBtn
                >
                <VBtn color="green" @click="onConnect" v-if="!slackIsActive"
                    >{{ lang.CONNECT }}</VBtn
                >
                <VBtn
                    color="orange"
                    @click="onConnect"
                    v-else-if="slackIsActive && slackData.webhook"
                    >{{ lang.UPDATE }}</VBtn
                >
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import * as getters from '@/store/modules/auth/types/getters';
import * as actions from '@/store/modules/auth/types/actions';
import * as langGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'SlackModalIntegration',
    data: () => ({
        dialog: false,
        slackData: {
            webhook: '',
            channel_name: ''
        },
        slackIsActive: false
    }),
    methods: {
        ...mapActions('auth', {
            connectSlack: actions.CONNECT_SLACK_NOTIFICATIONS
        }),
        updSlackData() {
            this.slackData.webhook = this.user.slack_webhook;
            this.slackData.channel_name = this.user.slack_channel;
            this.slackIsActive = this.user.slack_active;
        },
        async onConnect() {
            await this.connectSlack({
                incoming_webhook: this.slackData.webhook,
                channel_name: this.slackData.channel_name
            });
            this.dialog = false;
        }
    },
    computed: {
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        }),
        ...mapGetters('i18n', {
            lang: langGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
