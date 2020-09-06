export const eventTypeMapper = EventType => ({
    id: EventType.id,
    name: EventType.name,
    description: EventType.description || '',
    internalNote: EventType.internal_note,
    address: EventType.address,
    locationType: EventType.location_type,
    coordinates: eventTypeCoordinates(EventType.coordinates),
    slug: EventType.slug,
    color: EventType.color,
    duration: EventType.duration,
    disabled: EventType.disabled,
    timezone: EventType.timezone,
    owner: userMapper(EventType.owner),
    createdAt: EventType.created_at,
    chatito_workspace: EventType.chatito_workspace
});
export const userMapper = User => ({
    id: User.id,
    email: User.email,
    name: User.name,
    nickname: User.nickname,
    timezone: User.timezone,
    avatar: User.avatar,
    brandingLogo: User.branding_logo,
    timeFormat12h: User.time_format_12h
});

export const availabilityMapper = Availability => ({
    type: Availability.type,
    startDate: Availability.start_date,
    endDate: Availability.end_date
});

export const eventTypeCoordinates = coordinate => ({
    lng: coordinate['lng'] || coordinate[0],
    lat: coordinate['lat'] || coordinate[1]
});
