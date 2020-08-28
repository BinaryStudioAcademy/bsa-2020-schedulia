export const eventTypeMapper = EventType => ({
    id: EventType.id,
    name: EventType.name,
    description: EventType.description,
    slug: EventType.slug,
    color: EventType.color,
    duration: EventType.duration,
    disabled: EventType.disabled,
    timezone: EventType.timezone,
    owner: userMapper(EventType.owner),
    availabilities: EventType.availabilities.map(availabilityMapper)
});

export const userMapper = user => ({
    id: user.id,
    email: user.email,
    name: user.name,
    timezone: user.timezone,
    nickname: user.nickname
});

export const availabilityMapper = availability => ({
    type: availability.type,
    startDate: availability.start_date,
    endDate: availability.end_date
});

export const availabilityApiMapper = availability => ({
    type: availability.type,
    start_date: availability.startDate,
    end_date: availability.endDate,
    start_time: availability?.startTime,
    end_time: availability?.endTime
});

export const eventTypeFormMapper = eventTypeForm => ({
    name: eventTypeForm.name,
    location: eventTypeForm.location,
    description: eventTypeForm.description,
    slug: eventTypeForm.slug,
    color: eventTypeForm.color,
    duration: eventTypeForm.duration || eventTypeForm.customDuration,
    disabled: eventTypeForm.disabled,
    timezone: eventTypeForm.timezone,
    availabilities: availabilitiesMapper(eventTypeForm.availabilities)
});

export const availabilitiesMapper = function(availabilities) {
    return Object.entries(availabilities).flatMap(availabilities =>
        availabilities[1]
            .filter(
                availability => availability.startDate && availability.endDate
            )
            .map(availability => availabilityApiMapper(availability))
    );
};
