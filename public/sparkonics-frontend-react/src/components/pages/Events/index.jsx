import "./styles.scss";
import { useEffect, useState } from "react";
import { ProgressBar } from "../../molecules/index.jsx";
import { Button, FlexBox, Image, RelativeTime } from "../../atoms/index.jsx";
import clsx from "clsx";
import BackendAPI from "../../../api.jsx";

const Events = () => {
  const [events, setEvents] = useState([]);
  const [slideNumber, setSlideNumber] = useState(0);
  const [upcomingEvents, setUpcomingEvents] = useState([]);
  const [ongoingEvents, setOngoingEvents] = useState([]);
  const [pastEvents, setPastEvents] = useState([]);
  useEffect(() => {
    BackendAPI.get("/api/events")
      .then((data) => {
        console.log("Fetched data:", data);
        setEvents(data);
      })
      .catch((err) => console.error(err));
  }, []);
  useEffect(() => {
    const now = new Date();

    const upcoming = [];
    let ongoing = [];
    const past = [];

    events.map((event) => {
      const start = new Date(event.EventStartTime);
      const end = new Date(event.EventEndTime);

      if (start > now) upcoming.push(event);
      else if (start <= now && now <= end) ongoing.push(event);
      else past.push(event);
    });

    ongoing = ongoing.sort(() => Math.random() - 0.5);

    setUpcomingEvents(upcoming);
    setOngoingEvents(ongoing);
    setPastEvents(past);
  }, [events]);

  const formatEventTime = (isoString) => {
    const date = new Date(isoString);

    const datePart = date.toLocaleDateString("en-GB", {
      day: "2-digit",
      month: "short",
    });

    const timePart = date.toLocaleTimeString("en-US", {
      hour: "numeric",
      minute: "2-digit",
      hour12: true,
    });

    return `${datePart}`;
  };

  useEffect(() => {
    const interval = setInterval(() => {
      setSlideNumber((p) => (p + 1) % ongoingEvents.length);
    }, 15 * 1000);
    return () => clearInterval(interval);
  }, [ongoingEvents]);

  return (
    <div className="events">
      <ProgressBar />

      <div className="events-present">
        <div
          className="accordion-left"
          onClick={() => setSlideNumber((p) => (p - 1) % ongoingEvents.length)}
        >
          <span></span>
        </div>
        <FlexBox
          className="events"
          style={{
            transform: `translateX(-${(slideNumber % ongoingEvents.length) * 100}vw)`,
          }}
        >
          {ongoingEvents.map((event) => (
            <div className="event">
              <Image
                src={`${window.location.origin}${event.EventBanner}`}
                alt={`Banner for ${event.EventName}`}
                className={"event-banner"}
              />
              <FlexBox
                column
                align
                justify
                fullWidth
                className={"event-details"}
              >
                <span>
                  Ongoing event - Ends in{" "}
                  <RelativeTime value={event.EventEndTime} />{" "}
                </span>
                <h2>{event.EventName}</h2>
                <h3>{event.EventDomains.replaceAll(",", " •")}</h3>
                <p>{event.EventDescription}</p>
              </FlexBox>
            </div>
          ))}
        </FlexBox>

        <div
          className="accordion-right"
          onClick={() => setSlideNumber((p) => (p + 1) % ongoingEvents.length)}
        >
          <span></span>
        </div>

        <FlexBox justify align fullWidth className="slide-icons">
          {ongoingEvents.map((event, index) => (
            <div
              className={clsx(
                "slide-icon",
                index === slideNumber && "slide-icon-current",
              )}
              onClick={() => setSlideNumber(index)}
            ></div>
          ))}
        </FlexBox>
      </div>

      <FlexBox column className={"events-future"}>
        <h1>Up next</h1>

        {upcomingEvents.map((event) => (
          <FlexBox
            fullWidth
            justifyBetween
            className={"event animation-fade-slide-in"}
            key={event.EventId}
          >
            <FlexBox column className={"event-description"}>
              <FlexBox align>
                <h2>{event.EventName}</h2>
                <span style={{ margin: ".3rem" }}>—</span>
                <span>{formatEventTime(event.EventStartTime)}</span>
              </FlexBox>
              <h3>{event.EventDomains.replaceAll(",", " •")}</h3>
              <p>{event.EventDescription}</p>

              <span>
                Starts in <RelativeTime value={event.EventStartTime} />
              </span>
              <a href={event.EventRegisterLink} target={"_blank"}>
                <Button variant={"filled"} withShadow>
                  Register now
                </Button>
              </a>
            </FlexBox>
            <Image
              src={`http://localhost${event.EventBanner}`}
              alt={`Banner for ${event.EventName}`}
            />
          </FlexBox>
        ))}
      </FlexBox>
    </div>
  );
};

export default Events;
