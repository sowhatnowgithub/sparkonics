import "./styles.scss";
import {useEffect, useState} from "react";
import BackendAPI from "../../../../api.jsx";
import {Button, FlexBox} from "../../../atoms/index.jsx";
import {CreateModifyEventModal} from "../../../organisms/index.jsx";

const EventsModify = () => {
    const [events, setEvents] = useState([]);
    const [showCreate, setShowCreate] = useState(false);
    const [modifying, setModifying] = useState(null);
    
    useEffect(() => {
        BackendAPI.get("/api/events")
            .then((data) => setEvents(data))
            .catch((err) => console.error(err));
        
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
                                const confirmDelete = window.confirm(`Delete event "${event.name}"?`);
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