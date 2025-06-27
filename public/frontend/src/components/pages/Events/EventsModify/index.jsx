import "./styles.scss";
import { useEffect, useState } from "react";
import BackendAPI from "../../../../api.jsx";
import { Button, FlexBox } from "../../../atoms/index.jsx";
import { CreateModifyEventModal } from "../../../organisms/index.jsx";

const EventsModify = () => {
  const [events, setEvents] = useState([]);
  const [showCreate, setShowCreate] = useState(false);
  const [modifying, setModifying] = useState(null);

  useEffect(() => {
    BackendAPI.get("/api/events")
      .then((data) => setEvents(data))
      .catch((err) => console.error(err));
    /*
        setEvents([
                {
                    "id": 15,
                    "banner": "https://images.unsplash.com/photo-1515168844323-5cce7b847bfd",
                    "name": "Midnight Art Showcase",
                    "description": "An immersive digital exhibition featuring contemporary art.",
                    "startTime": "2025-07-15T23:30",
                    "endTime": "2025-07-16T02:30"
                },
                {
                    "id": 14,
                    "banner": "https://images.unsplash.com/photo-1551434678-e076c223a692",
                    "name": "Creative Writing Sprint",
                    "description": "Craft short stories with on-the-spot prompts.",
                    "startTime": "2025-07-14T11:00",
                    "endTime": "2025-07-14T13:30"
                },
                {
                    "id": 13,
                    "banner": "https://images.unsplash.com/photo-1542744173-8e7e53415bb0",
                    "name": "Startup Networking Mixer",
                    "description": "Founders and techies connect over drinks and demos.",
                    "startTime": "2025-07-13T18:00",
                    "endTime": "2025-07-13T21:00"
                },
                {
                    "id": 12,
                    "banner": "https://images.unsplash.com/photo-1505238680356-667803448bb6",
                    "name": "Anime Drawing Marathon",
                    "description": "Sketch your favorite characters with guidance from pros.",
                    "startTime": "2025-07-12T13:00",
                    "endTime": "2025-07-12T15:00"
                },
                {
                    "id": 11,
                    "banner": "https://images.unsplash.com/photo-1531058020387-3be344556be6",
                    "name": "Indie Game Jam",
                    "description": "Build a playable game prototype in 3 hours!",
                    "startTime": "2025-07-11T16:00",
                    "endTime": "2025-07-11T19:00"
                },
                {
                    "id": 10,
                    "banner": "https://images.unsplash.com/photo-1481277542470-605612bd2d61",
                    "name": "Climate Change Panel",
                    "description": "Experts talk about real-world solutions to global warming.",
                    "startTime": "2025-07-10T17:00",
                    "endTime": "2025-07-10T19:00"
                },
                {
                    "id": 9,
                    "banner": "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40",
                    "name": "Photography Masterclass",
                    "description": "Professional photographers share their top tips and tricks.",
                    "startTime": "2025-07-09T09:30",
                    "endTime": "2025-07-09T12:00"
                },
                {
                    "id": 8,
                    "banner": "https://images.unsplash.com/photo-1506973035872-a4ec16b8d6b0",
                    "name": "Virtual Book Club",
                    "description": "Discuss July's read with fellow literature lovers.",
                    "startTime": "2025-07-08T19:00",
                    "endTime": "2025-07-08T20:00"
                },
                {
                    "id": 7,
                    "banner": "https://images.unsplash.com/photo-1504384764586-bb4cdc1707b0",
                    "name": "UX/UI Design Workshop",
                    "description": "Create stunning interfaces with expert design mentors.",
                    "startTime": "2025-07-07T15:00",
                    "endTime": "2025-07-07T17:30"
                },
                {
                    "id": 6,
                    "banner": "https://images.unsplash.com/photo-1497493292307-31c376b6e479",
                    "name": "Live Indie Music Night",
                    "description": "Enjoy performances by local independent bands.",
                    "startTime": "2025-07-06T20:00",
                    "endTime": "2025-07-06T22:30"
                },
                {
                    "id": 5,
                    "banner": "https://images.unsplash.com/photo-1515168833906-d2a3b82b3024",
                    "name": "Evening Meditation Circle",
                    "description": "Join a guided group meditation session to de-stress.",
                    "startTime": "2025-07-05T18:30",
                    "endTime": "2025-07-05T20:00"
                },
                {
                    "id": 4,
                    "banner": "https://images.unsplash.com/photo-1475727946784-2c0f3f89f251",
                    "name": "Digital Marketing 101",
                    "description": "Learn the fundamentals of digital advertising and SEO.",
                    "startTime": "2025-07-04T11:30",
                    "endTime": "2025-07-04T13:00"
                },
                {
                    "id": 3,
                    "banner": "https://images.unsplash.com/photo-1515165562835-c1c4e1387a5b",
                    "name": "Virtual Coding Bootcamp",
                    "description": "A 3-hour hands-on session on building full-stack web apps.",
                    "startTime": "2025-07-03T14:00",
                    "endTime": "2025-07-03T17:00"
                },
                {
                    "id": 2,
                    "banner": "https://images.unsplash.com/photo-1522199755839-a2bacb67c546",
                    "name": "Tech Startup Pitch Fest",
                    "description": "Watch the most innovative startups pitch their ideas to top investors.",
                    "startTime": "2025-07-02T10:00",
                    "endTime": "2025-07-02T13:00"
                },
                {
                    "id": 1,
                    "banner": "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee",
                    "name": "Sunset Yoga Retreat",
                    "description": "A calming outdoor yoga experience to unwind and reconnect.",
                    "startTime": "2025-07-01T06:00",
                    "endTime": "2025-07-01T08:00"
                }
                ]); */
  }, []);

  const formatIST = (dateString) => {
    const options = {
      hour: "numeric",
      minute: "2-digit",
      hour12: true,
      day: "2-digit",
      month: "long",
      year: "2-digit",
      timeZone: "Asia/Kolkata",
    };

    return new Date(dateString)
      .toLocaleString("en-IN", options)
      .replace(",", "");
  };

  return (
    <div>
      <FlexBox justifyEnd fullWidth>
        <Button onClick={() => setShowCreate(true)} variant={"filled"}>
          Add event
        </Button>
      </FlexBox>
      <CreateModifyEventModal
        show={showCreate || modifying}
        event={modifying}
        onClose={() => {
          if (showCreate) setShowCreate(false);
          if (modifying) setModifying(null);
        }}
        onCreate={(newEvent) => setEvents((p) => [newEvent, ...p])}
        onModify={(newEvent) => {
          setEvents((prevEvents) =>
            prevEvents.map((event) =>
              event.id === newEvent.id ? newEvent : event,
            ),
          );
        }}
      />
      <table className="modify-events-table">
        <thead>
          <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Domains</td>
            <td>Status</td>
            <td>Start Time</td>
            <td>End Time</td>
            <td>Register Link</td>
            <td>Modify</td>
            <td>Delete</td>
          </tr>
        </thead>
        <tbody>
          {events.map((event) => (
            <tr key={event.EventId}>
              <td>{event.EventId}</td>
              <td>{event.EventName}</td>
              <td>{event.EventDescription}</td>
              <td>{event.EventDomains}</td>
              <td>{event.EventStatus}</td>
              <td>{formatIST(event.EventStartTime)}</td>
              <td>{formatIST(event.EventEndTime)}</td>
              <td>
                <a
                  href={event.EventRegisterLink}
                  target="_blank"
                  rel="noreferrer"
                >
                  Link
                </a>
              </td>
              <td className="table-control" onClick={() => setModifying(event)}>
                [modify]
              </td>
              <td
                className="table-control"
                onClick={async () => {
                  const confirmDelete = window.confirm(
                    `Delete event "${event.EventName}"?`,
                  );
                  if (!confirmDelete) return;

                  try {
                    await BackendAPI.delete(`/events/${event.EventId}`);
                    setEvents((prev) =>
                      prev.filter((e) => e.EventId !== event.EventId),
                    );
                  } catch (err) {
                    console.error("Failed to delete event:", err);
                    alert("Failed to delete the event. Please try again.");
                  }
                }}
              >
                [delete]
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default EventsModify;
