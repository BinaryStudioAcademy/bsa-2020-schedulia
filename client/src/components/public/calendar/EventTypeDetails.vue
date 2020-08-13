<template>
    <div class="main">
        <div class="event-type-container">
            <VRow>
                <VCol sm="2" md="3" class="col-1"></VCol>
                <VCol sm="8" md="6" class="detail-content col-10">
                    <div class="detail-content-top mt-3 mb-5">
                        <VLayout justify-center>
                            <VAvatar size="70px" class="avatar">
                                <img :src="owner.avatar" alt="Avatar" />
                            </VAvatar>
                        </VLayout>
                        <h3 class="text-center mt-5 mb-2">
                            {{ lang.CONFIRMED }}
                        </h3>
                        <p class="text-center">
                            {{ lang.YOU_ARE_SCHEDULED_WITH }} {{ owner.name }} |
                            {{ owner.company }}
                        </p>
                    </div>
                    <VDivider></VDivider>
                    <div class="detail-content-main mt-3 mb-3">
                        <div class="event-info">
                            <VIcon color="green">mdi-circle</VIcon>
                            <h3 class="d-inline">{{ owner.specialty }}</h3>
                        </div>
                        <div class="event-info">
                            <VIcon dark color="primary"
                                >mdi-calendar-blank</VIcon
                            >
                            {{ meetingDate }}
                        </div>
                        <div class="event-info">
                            <VIcon dark color="primary">mdi-earth</VIcon>
                            {{ timezone }}
                        </div>
                        <div class="event-info">
                            <VIcon dark color="primary">mdi-map-marker</VIcon>
                            {{ meetingLocation }}
                        </div>
                    </div>
                    <div class="detail-content-bottom mt-5">
                        <p class="text-center">
                            {{ lang.CALENDAR_INVITATION_HAS_BEEN_SENT }}
                        </p>
                    </div>
                </VCol>
                <VCol sm="2" md="3" class="col-1"></VCol>
            </VRow>
        </div>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'EventTypeDetails',
    components: {},
    data: () => ({
        lang: enLang,
        owner: {
            name: 'Michael Scott',
            avatar:
                'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
            company: 'Dunder Mifflin',
            specialty: 'Sales manager'
        },
        meetingDate: '10:00-10:15, Monday, July 20, 2020',
        timezone: 'Eastern European Time',
        meetingLocation: 'Scranton, Pennsylvania'
    })
};
</script>

<style>
.main {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.event-type-container {
    margin-top: 50px;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
    background-color: #fff;
    width: 70%;
    height: 70%;
    max-width: 1000px;
    max-height: 900px;
}

.circle {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.event-info {
    display: flex;
    padding: 6px 0 6px 0;
    margin-top: 6px;
}

.event-info i {
    margin-right: 10px;
}

@media screen and (max-width: 960px) {
    .event-type-container {
        width: 90%;
        height: 80%;
    }
}

@media (max-width: 600px) {
    .event-type-container {
        width: 100%;
        box-shadow: none;
    }
}
</style>
