//import requestService from "@/services/requestService";
//const EVENT_TYPES_URL = "/event-types";
//const EVENTS_URL = "/events";

const publicEventService = {
    async getEventTypeById(id) {
        //const response = await requestService.get(`${EVENT_TYPES_URL}/${id}`);

        const testData = {
            id,
            name: 'Sales manager',
            duration: 30,
            location: 'Scranton, Pennsylvania',
            description: '',
            timezone: 'Europe/Kiev',
            startDate: '2020-09-08 11:00:00',
            color: 'red',
            slug: 'collaboration-with-binary-studio',
            owner: {
                name: 'Michael Scott | Dunder Mifflin',
                avatar:
                    'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
                time_format_12h: false,
                branding_logo:
                    'https://i.etsystatic.com/16438614/r/il/c31bd2/1806659071/il_570xN.1806659071_pn8j.jpg'
            },
            availabilities: [
                {
                    type: 'one to many',
                    start_date: '2020-09-08 11:00:00',
                    end_date: '2020-09-18 17:00:00'
                },
                {
                    type: 'one to many',
                    start_date: '2020-09-20 09:00:00',
                    end_date: '2020-09-23 19:00:00'
                }
            ]
        };
        await new Promise(resolve => setTimeout(resolve, 1000));
        return Promise.resolve(testData);
        //return response?.data?.data;
    },
    async addPublicEvent() {
        //const response = await requestService.post(EVENTS_URL, data);
        await new Promise(resolve => setTimeout(resolve, 1000));
        //return response?.data?.data;
    }
};

export default publicEventService;
