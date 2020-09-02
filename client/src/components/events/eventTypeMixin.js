import { mapActions, mapGetters } from 'vuex';
import * as actionEventType from '@/store/modules/eventType/types/actions';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    data() {
        return {
            colorById: {
                yellow: {
                    id: 'yellow',
                    image: require('@/assets/images/color_circles/yellow_circle.svg')
                },
                red: {
                    id: 'red',
                    image: require('@/assets/images/color_circles/red_circle.svg')
                },
                blue: {
                    id: 'blue',
                    image: require('@/assets/images/color_circles/blue_circle.svg')
                },
                green: {
                    id: 'green',
                    image: require('@/assets/images/color_circles/green_circle.svg')
                },

                purple: {
                    id: 'purple',
                    image: require('@/assets/images/color_circles/purple_circle.svg')
                },

                turquoise: {
                    id: 'turquoise',
                    image: require('@/assets/images/color_circles/turquoise_circle.svg')
                },

                pink: {
                    id: 'pink',
                    image: require('@/assets/images/color_circles/pink_circle.svg')
                },
                dark_blue: {
                    id: 'dark_blue',
                    image: require('@/assets/images/color_circles/dark-blue_circle.svg')
                }
            },
            showGeocoder: false
        };
    },

    methods: {
        ...mapActions('eventType', {
            setEventType: actionEventType.SET_EVENT_TYPE,
            setProperty: actionEventType.SET_PROPERTY
        }),

        changeEventTypeProperty(property, value) {
            let data = {};
            switch (property) {
                case 'name':
                    data[property] = value;
                    if (
                        this.data.slug.toLowerCase() ===
                        this.data.name.toLowerCase()
                    ) {
                        data['slug'] = this.getSlug(value);
                    }
                    break;
                case 'slug':
                    data[property] = this.getSlug(value);
                    break;
                case 'color':
                    data[property] = this.colorById[value].id;
                    break;
                case 'duration':
                    data[property] = value;
                    data['customDuration'] = 0;
                    break;
                case 'customDuration':
                    data[property] = value;
                    data['duration'] = 0;
                    break;
                case 'locationType':
                    data[property] = value;
                    this.showGeocoder = false;
                    data['location'] = '';
                    data['coordinates'] = [];
                    if (!!value && value.title === 'address on the map') {
                        this.showGeocoder = true;
                    } else if (!!value && value.title === 'zoom') {
                        this.showZoomDialog = true;
                    } else if (!!value && value.title === 'skype') {
                        this.showSkypeDialog = true;
                    }
                    break;
                default:
                    data[property] = value;
                    break;
            }
            this.setEventType(data);
        },

        setPropertyData(property, value) {
            this.setProperty({
                property: property,
                value: value
            });
        }
    },

    computed: {
        ...mapGetters('eventType', {
            eventType: eventTypeGetters.GET_EVENT_TYPE
        }),
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        data() {
            return this.eventType;
        },
        dateDuration() {
            let result = '';
            switch (this.data.dateRange.scheduleType) {
                case 'period':
                    result =
                        this.data.dateRange.value +
                        ' ' +
                        (this.data.dateRange.scheduleType === 'calendar'
                            ? this.lang.DAYS_FORMAT_ITEMS_CALENDAR
                            : this.lang.DAYS_FORMAT_ITEMS_BUSINESS);
                    break;
                case 'range':
                    if (this.data.dateRange.date.length === 1) {
                        result = this.data.dateRange.date[0];
                    } else {
                        result = `from ${this.data.dateRange.date[0]} to ${this.data.dateRange.date[1]}`;
                    }
                    break;
                case 'indefinite':
                    result = 'indefinitely';
                    break;
            }

            return result;
        }
    }
};
