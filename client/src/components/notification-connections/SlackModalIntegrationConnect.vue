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
                <span class="headline">Connect Slack</span>
            </VCardTitle>
            <VCardText>
                <span class="subtitle-2">Incoming Webhook</span>
                <VListItem>
                    <VListItemContent>
                        <VListItemTitle>Add
                            <a href="https://slack.com/apps/A0F7XDUAZ-incoming-webhooks" target="_blank">
                                Incoming Webhook
                            </a>
                            to your <b>Slack</b> workspace.</VListItemTitle>
                    </VListItemContent>
                </VListItem>

                <VListItem>
                    <VListItemContent>
                        <VListItemTitle>Past <b>Incoming Webhook</b> in the field:</VListItemTitle>
                    </VListItemContent>
                </VListItem>
                <VTextField
                    dense
                    solo
                    outlined
                    v-model="slackData.webhook"
                >
                </VTextField>

                <span class="subtitle-2">Channel name</span>
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
                    >Close</VBtn
                >
                <VBtn
                    color="green"
                    @click="onConnect"
                    v-if="!slackIsActive"
                    >Connect</VBtn
                >
                <VBtn
                    color="orange"
                    @click="onConnect"
                    v-else
                >Update</VBtn
                >
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
// import { required } from 'vuelidate/lib/validators';
import { validationMixin } from 'vuelidate';
import { mapGetters, mapActions } from 'vuex';
import * as getters from '@/store/modules/auth/types/getters';
import * as actions from '@/store/modules/auth/types/actions';

export default {
    name: 'SlackModalIntegration',
    mixins: [validationMixin],
    // validations: {
    //     incomingWebhook: {
    //         required
    //     },
    //     channelName: {
    //         required
    //     }
    // },
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
        })
    }
};
</script>

<style scoped>

</style>