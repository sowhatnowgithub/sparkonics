import "./styles.scss"
import {useEffect, useState} from "react";
import {ProgressBar} from "../../../molecules/index.jsx";
import {Button, FlexBox, Image, RelativeTime} from "../../../atoms/index.jsx";
import clsx from "clsx";


const EventsLanding = () => {
    const [slideNumber, setSlideNumber] = useState(0)
    const [upcomingEvents, setUpcomingEvents] = useState([])
    const [ongoingEvents, setOngoingEvents] = useState([])
    const [pastEvents, setPastEvents] = useState([])
    
    
    useEffect(() => {
        // BackendAPI
        //     .get("/events/")
        //     .then(data => setEvents(data))
        //     .catch(err => console.error(err))
        
        let events = [
            // PAST EVENTS
            {
                EventId: 1,
                EventName: "Summer Kickoff",
                EventDescription: "A festival to start the summer.",
                EventStartTime: "2025-06-20T14:00",
                EventEndTime: "2025-06-20T18:00",
                EventRegisterLink: "https://example.com/register/1",
                EventBanner: "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee",
                EventDomains: "Entertainment, Festival"
            },
            {
                EventId: 2,
                EventName: "AI Webinar",
                EventDescription: "Deep dive into AI ethics.",
                EventStartTime: "2025-06-21T16:00",
                EventEndTime: "2025-06-21T17:00",
                EventRegisterLink: "https://example.com/register/2",
                EventBanner: "https://images.unsplash.com/photo-1551434678-e076c223a692",
                EventDomains: "Technology, AI, Ethics"
            },
            {
                EventId: 3,
                EventName: "Beach Clean-up Drive",
                EventDescription: "Volunteers gather to clean up the local beaches.",
                EventStartTime: "2025-06-22T08:00",
                EventEndTime: "2025-06-22T11:30",
                EventRegisterLink: "https://example.com/register/3",
                EventBanner: "https://images.unsplash.com/photo-1522199755839-a2bacb67c546",
                EventDomains: "Environment, Volunteering"
            },
            
            // ONGOING EVENTS (at least 1 week long and active on 1st July 2025, 1 PM)
            {
                EventId: 4,
                EventName: "Startup Showcase",
                EventDescription: "Local startups pitch live to investors throughout the week.",
                EventStartTime: "2025-06-28T10:00",
                EventEndTime: "2025-07-08T18:00",
                EventRegisterLink: "https://example.com/register/4",
                EventBanner: "https://images.unsplash.com/photo-1531058020387-3be344556be6",
                EventDomains: "Entrepreneurship, Business, Technology"
            },
            {
                EventId: 5,
                EventName: "Midday Mindfulness Week",
                EventDescription: "Week-long guided mindfulness and meditation sessions.",
                EventStartTime: "2025-06-30T09:00",
                EventEndTime: "2025-07-08T13:00",
                EventRegisterLink: "https://example.com/register/5",
                EventBanner: "https://images.unsplash.com/photo-1504384764586-bb4cdc1707b0",
                EventDomains: "Health, Wellness, Lifestyle"
            },
            {
                EventId: 6,
                EventName: "UX/UI Design Bootcamp",
                EventDescription: "Hands-on sessions to improve product design skills over a week.",
                EventStartTime: "2025-06-29T11:00",
                EventEndTime: "2025-07-09T17:00",
                EventRegisterLink: "https://example.com/register/6",
                EventBanner: "https://images.unsplash.com/photo-1505238680356-667803448bb6",
                EventDomains: "Design, Technology, UI/UX"
            },
            
            // UPCOMING EVENTS
            {
                EventId: 7,
                EventName: "3D Art Workshop",
                EventDescription: "Learn sculpting in virtual space.",
                EventStartTime: "2025-07-09T16:00",
                EventEndTime: "2025-07-09T18:30",
                EventRegisterLink: "https://example.com/register/7",
                EventBanner: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40",
                EventDomains: "Art, Technology, Workshop"
            },
            {
                EventId: 8,
                EventName: "Night Sky Photography",
                EventDescription: "Capture the Milky Way with guidance from pros.",
                EventStartTime: "2025-07-10T21:00",
                EventEndTime: "2025-07-10T23:59",
                EventRegisterLink: "https://example.com/register/8",
                EventBanner: "https://images.unsplash.com/photo-1515165562835-c1c4e1387a5b",
                EventDomains: "Photography, Nature, Outdoors"
            },
            {
                EventId: 9,
                EventName: "Futurist Talk: AI x Humanity",
                EventDescription: "Explore the intersection of technology and ethics.",
                EventStartTime: "2025-07-11T09:00",
                EventEndTime: "2025-07-11T11:00",
                EventRegisterLink: "https://example.com/register/9",
                EventBanner: "https://images.unsplash.com/photo-1481277542470-605612bd2d61",
                EventDomains: "Futurism, AI, Ethics"
            }
        ];
        
        
        const now = new Date();
        
        const upcoming = [];
        let ongoing = [];
        const past = [];
        
        events.map(event => {
            const start = new Date(event.EventStartTime)
            const end = new Date(event.EventEndTime)
            
            if (start > now) upcoming.push(event)
            else if (start <= now && now <= end) ongoing.push(event)
            else past.push(event)
        })
        
        ongoing = ongoing.sort(() => Math.random() - .5)
        
        setUpcomingEvents(upcoming)
        setOngoingEvents(ongoing)
        setPastEvents(past)
    }, [])
    
    const formatEventTime = (isoString) => {
        const date = new Date(isoString);
        
        const datePart = date.toLocaleDateString("en-GB", {
            day: "2-digit",
            month: "short",
        });
        
        const timePart = date.toLocaleTimeString("en-US", {
            hour: "numeric",
            minute: "2-digit",
            hour12: true
        });
        
        return `${datePart}`;
    };
    
    
    useEffect(() => {
        const interval = setInterval(() => {
            setSlideNumber(p => (p + 1) % ongoingEvents.length)
        }, 15 * 1000);
        return () => clearInterval(interval);
    }, [ongoingEvents]);
    
    return (
        <div className="events">
            <ProgressBar/>
            
            <div className="events-present">
                <div className="accordion-left" onClick={() => setSlideNumber(p => (p - 1) % ongoingEvents.length)}>
                    <span></span>
                </div>
                <FlexBox
                    className="events"
                    style={{ transform: `translateX(-${(slideNumber % ongoingEvents.length) * 100}vw)` }}
                    >
                    {ongoingEvents.map(event => (
                        <div className="event">
                            <Image src={event.EventBanner} alt={`Banner for ${event.EventName}`} className={"event-banner"}/>
                            
                            <FlexBox column align justify fullWidth className={"event-details"}>
                                <span>Ongoing event - Ends in <RelativeTime value={event.EventEndTime} /> </span>
                                <h2>{event.EventName}</h2>
                                <h3>{event.EventDomains.replaceAll(",", " •")}</h3>
                                <p>{event.EventDescription}</p>
                            </FlexBox>
                        
                        </div>
                    ))}
                </FlexBox>
                
                <div className="accordion-right" onClick={() => setSlideNumber(p => (p + 1) % ongoingEvents.length)}>
                    <span></span>
                </div>
                
                <FlexBox justify align fullWidth className="slide-icons">
                    {ongoingEvents.map((event, index) => (
                        <div className={clsx("slide-icon", index === slideNumber && 'slide-icon-current')} onClick={() => setSlideNumber(index)}></div>
                    ))}
                </FlexBox>
            </div>
            
            
            
            
            
            
            <FlexBox column className={"events-future"}>
                <h1>Up next</h1>
                
                {upcomingEvents.map(event => (
                    <FlexBox fullWidth justifyBetween className={"event animation-fade-slide-in"} key={event.EventId}>
                        <FlexBox column className={"event-description"}>
                            <FlexBox align>
                                <h2>{event.EventName}</h2>
                                <span style={{margin: ".3rem"}}>—</span>
                                <span>{formatEventTime(event.EventStartTime)}</span>
                            </FlexBox>
                            <h3>{event.EventDomains.replaceAll(",", " •")}</h3>
                            <p>{event.EventDescription}</p>
                            
                            <span>Starts in <RelativeTime value={event.EventStartTime}/></span>
                            <a href={event.EventRegisterLink} target={"_blank"}>
                                <Button variant={"filled"} withShadow>
                                    Register now
                                </Button>
                            </a>
                        </FlexBox>
                        <Image src={event.EventBanner} alt={`Banner for ${event.EventName}`}/>
                    </FlexBox>
                ))}
            </FlexBox>
        
        </div>
    )
}

export default EventsLanding;
