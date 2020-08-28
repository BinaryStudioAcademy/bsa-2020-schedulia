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
