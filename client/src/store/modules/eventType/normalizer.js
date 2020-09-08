import moment from 'moment';
export const eventTypeMapper = EventType => ({
    id: EventType.id,
    name: EventType.name,
    description: EventType.description || '',
    internalNote: EventType.internal_note,
    locationType: locationTypeMapper(EventType.location_type),
    coordinates: EventType.coordinates || [],
    address: EventType.address,
    slug: EventType.slug,
    color: EventType.color,
    duration: EventType.duration,
    disabled: EventType.disabled,
    timezone: EventType.timezone,
    owner: userMapper(EventType.owner),
    availabilities: availabilityMapper(EventType.availabilities),
    radioTimeZone: 'Local',
    customDuration: 0,
    dateRange: dateRangeMapper(EventType.availabilities),
    availabilities_week_days: availabilitiesWeekDays(EventType.availabilities),
    selectDay: {
        date: moment().format('YYYY-MM-DD')
    },
    createdAt: EventType.created_at,
    chatito_workspace: EventType.chatito_workspace
    // tagChecks: tagMapper(EventType.tags)
    // TODO: rename to 'tags' for correct cancelling
});

export const tagMapper = function(tags) {
    let result = [];

    tags.forEach(tag => {
        result.push(tag.name);
    });

    return result;
};

export const userMapper = user => ({
    id: user.id,
    email: user.email,
    name: user.name,
    timezone: user.timezone,
    nickname: user.nickname
});

export const availabilityMapper = function(availabilities) {
    let result = {};
    for (let index in availabilities) {
        let availability = availabilities[index];
        if (availability['type'] === 'exact_date') {
            let defaultStartDate = moment(availability['start_date']);
            let defaultEndDate = moment(availability['end_date']);
            let date = defaultStartDate.format('YYYY-MM-DD');
            if (!Object.keys(result).includes(date)) {
                result[date] = [];
            }
            result[date].push({
                type: availability.type,
                startDate: defaultStartDate.format('YYYY-MM-DD HH:mm:ss'),
                endDate: defaultEndDate.format('YYYY-MM-DD HH:mm:ss'),
                startTime: defaultStartDate.format('HH:mm'),
                endTime: defaultEndDate.format('HH:mm')
            });
        }
    }

    return result;
};

export const availabilityApiMapper = function(availability, timezone) {
    let startDate = moment.utc(moment(availability.startDate), timezone);
    let endDate = moment.utc(moment(availability.endDate), timezone);
    return {
        type: availability.type,
        start_date: startDate.format('YYYY-MM-DD HH:mm:ss'),
        end_date: endDate.format('YYYY-MM-DD HH:mm:ss'),
        start_Time: startDate.format('HH:mm:ss'),
        end_time: endDate.format('HH:mm:ss')
    };
};

export const eventTypeFormMapper = eventTypeForm => ({
    name: eventTypeForm.name,
    address: eventTypeForm.address,
    location_type: eventTypeForm.locationType.key,
    coordinates: eventTypeCoordinates(eventTypeForm.coordinates),
    description: eventTypeForm.description,
    slug: eventTypeForm.slug,
    color: eventTypeForm.color,
    duration: eventTypeForm.duration || eventTypeForm.customDuration,
    disabled: eventTypeForm.disabled,
    timezone: eventTypeForm.timezone,
    availabilities: availabilitiesMapper(eventTypeForm),
    chatito_workspace: eventTypeForm.chatito_workspace,
    tags: eventTypeForm.tagChecks
});

export const availabilitiesMapper = function(eventTypeForm) {
    return Object.entries(
        eventTypeForm.availabilities
    ).flatMap(availabilities =>
        availabilities[1]
            .filter(
                availability => availability.startDate && availability.endDate
            )
            .map(availability =>
                availabilityApiMapper(availability, eventTypeForm.timezone)
            )
    );
};

export const eventTypeTagMapper = EventTypeTag => ({
    id: EventTypeTag.id,
    name: EventTypeTag.name
});

export const eventTypeCoordinates = coordinate => ({
    lng: coordinate['lng'] || coordinate[0],
    lat: coordinate['lat'] || coordinate[1]
});

export const dateRangeMapper = function(availabilities) {
    for (let index in availabilities) {
        let availability = availabilities[index];
        if (availability.type.includes('date_range')) {
            let defaultStartDate = moment(availability.start_date);
            let defaultEndDate = moment(availability.end_date);
            return {
                type: availability.type,
                scheduleType: 'period',
                subType: availability.type,
                value: defaultEndDate.diff(defaultStartDate, 'days') + 1,
                date: [],
                startDate: defaultStartDate.format('YYYY-MM-DD'),
                endDate: defaultEndDate.format('YYYY-MM-DD'),
                startTime: defaultStartDate.format('HH:mm'),
                endTime: defaultEndDate.format('HH:mm')
            };
        }
    }
};

export const availabilitiesWeekDays = function(availabilities) {
    let result = {};
    for (let index in availabilities) {
        let availability = availabilities[index];
        if (availability.type.includes('every_')) {
            let defaultStartDate = moment(availability.start_date);
            let defaultEndDate = moment(availability.end_date);
            let weekDay = availability.type.replace(/every_/, '');
            if (!Object.keys(result).includes(weekDay)) {
                result[weekDay] = [];
            }
            result[weekDay].push({
                type: availability.type,
                startDate: defaultStartDate.format('YYYY-MM-DD HH:mm:ss'),
                endDate: defaultEndDate.format('YYYY-MM-DD HH:mm:ss'),
                startTime: defaultStartDate.format('HH:mm'),
                endTime: defaultEndDate.format('HH:mm')
            });
        }
    }
    return result;
};

export const locationTypeMapper = function(locationType) {
    let result = {};
    switch (locationType) {
        case 'address':
            result = {
                key: 'address',
                title: 'address',
                icon: 'mdi-google-maps'
            };
            break;
        case 'zoom':
            result = { key: 'zoom', title: 'zoom', icon: 'mdi-video-box' };
            break;
    }

    return result;
};

export const eventTypeDefaultMapper = function() {
    return {
        id: null,
        name: '',
        address: '',
        coordinates: [],
        locationType: '',
        description: '',
        slug: '',
        color: 'yellow',
        disabled: false,
        duration: 30,
        customDuration: 0,
        timezone: '',
        radioTimeZone: 'Local',
        dateRange: {
            type: 'date_range',
            scheduleType: 'period',
            subType: 'date_range',
            value: 60,
            date: [],
            startDate: moment().format('YYYY-MM-DD'),
            endDate: moment()
                .add(59, 'days')
                .format('YYYY-MM-DD'),
            startTime: '09:00',
            endTime: '17:00'
        },
        availabilities_week_days: {},
        availabilities: {},
        selectDay: {
            date: moment().format('YYYY-MM-DD')
        },
        chatito_workspace: '',
        tagChecks: []
    };
};
