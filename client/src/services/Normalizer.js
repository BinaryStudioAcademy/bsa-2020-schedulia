export const eventTypeMapper = eventType => ({
    id: eventType.id,
    name: eventType.name,
    description: eventType.description,
    slug: eventType.slug,
    color: eventType.color,
    duration: eventType.duration,
    disabled: eventType.disabled,
    timezone: eventType.timezone,
    owner: userMapper(eventType.owner),
    availabilities: eventType.availabilities.map(availabilityMapper)
});

export const userMapper = user => ({
    id: user.id,
    email: user.email,
    name: user.name,
    timezone: user.timezone
});

export const availabilityMapper = availability => ({
    type: availability.type,
    startDate: availability.start_date,
    endDate: availability.end_date
});
