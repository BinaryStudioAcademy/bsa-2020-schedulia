export const EventTypeMapper = EventType => ({
    id: EventType.id,
    name: EventType.name,
    description: EventType.description,
    slug: EventType.slug,
    color: EventType.color,
    duration: EventType.duration,
    disabled: EventType.disabled,
    timezone: EventType.timezone,
    owner: UserMapper(EventType.owner),
    availabilities: EventType.availabilities.map(AvailabilityMapper)
});

export const UserMapper = User => ({
    id: User.id,
    email: User.email,
    name: User.name,
    timezone: User.timezone,
    avatar: User.avatar,
    brandingLogo: User.branding_logo,
    timeFormat12h: User.time_format_12h
});

export const AvailabilityMapper = Availability => ({
    type: Availability.type,
    startDate: Availability.start_date,
    endDate: Availability.end_date
});
