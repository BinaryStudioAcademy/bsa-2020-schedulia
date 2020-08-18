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
    timezone: User.timezone
});

export const AvailabilityMapper = Availability => ({
    type: Availability.type,
    startDate: Availability.start_date,
    endDate: Availability.end_date
});

export const AvailabilityApiMapper = Availability => ({
    type: Availability.type,
    start_date: Availability.startDate,
    end_date: Availability.endDate
});

export const EventTypeFormMapper = EventTypeForm => ({
    name: EventTypeForm.name,
    location: EventTypeForm.location,
    description: EventTypeForm.description,
    slug: EventTypeForm.slug,
    color: EventTypeForm.color,
    duration: EventTypeForm.duration || EventTypeForm.customDuration,
    disabled: EventTypeForm.disabled,
    timezone: EventTypeForm.timezone,
    availabilities: AvailabilitiesMapper(EventTypeForm.availabilities),
});

export const AvailabilitiesMapper = function (Availabilities) {
    let availabilities = [];
    for (let index in Availabilities) {
        Availabilities[index].map(function(availability) {
            if (availability.endDate && availability.endDate) {
                availabilities.push(AvailabilityApiMapper(availability));
            }
        });
    }

    return availabilities;
};