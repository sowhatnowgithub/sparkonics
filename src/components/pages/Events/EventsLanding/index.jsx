import {useEffect, useState} from "react";

const EventsLanding = () => {
    const [upcomingEvents, setUpcomingEvents] = useState([])
    const [ongoingEvents, setOngoingEvents] = useState([])
    const [pastEvents, setPastEvents] = useState([])
    
    
    useEffect(() => {
        // BackendAPI
        //     .get("/events/")
        //     .then(data => setEvents(data))
        //     .catch(err => console.error(err))
        
        let events = [
            {
                "id": 1,
                "name": "Summer Kickoff",
                "banner": "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee",
                "description": "A festival to start the summer.",
                "startTime": "2025-06-20T14:00",
                "endTime": "2025-06-20T18:00"
            },
            {
                "id": 2,
                "name": "AI Webinar",
                "banner": "https://images.unsplash.com/photo-1551434678-e076c223a692",
                "description": "Deep dive into AI ethics.",
                "startTime": "2025-06-21T16:00",
                "endTime": "2025-06-21T17:00"
            },
            {
                "id": 3,
                "name": "Beach Clean-up Drive",
                "banner": "https://images.unsplash.com/photo-1522199755839-a2bacb67c546",
                "description": "Volunteers gather to clean up the local beaches.",
                "startTime": "2025-06-22T08:00",
                "endTime": "2025-06-22T11:30"
            },
            {
                "id": 4,
                "name": "Startup Showcase",
                "banner": "https://images.unsplash.com/photo-1531058020387-3be344556be6",
                "description": "Local startups pitch live to investors.",
                "startTime": "2025-06-25T16:00",
                "endTime": "2025-06-25T18:30"
            },
            {
                "id": 5,
                "name": "Open Mic Poetry",
                "banner": "https://images.unsplash.com/photo-1481277542470-605612bd2d61",
                "description": "An evening of expression and spoken word.",
                "startTime": "2025-06-25T15:30",
                "endTime": "2025-06-25T17:30"
            },
            {
                "id": 6,
                "name": "Live Coding Jam",
                "banner": "https://images.unsplash.com/photo-1505238680356-667803448bb6",
                "description": "Watch devs solve challenges live.",
                "startTime": "2025-06-25T16:45",
                "endTime": "2025-06-25T19:00"
            },
            {
                "id": 7,
                "name": "Music Night",
                "banner": "https://images.unsplash.com/photo-1504384764586-bb4cdc1707b0",
                "description": "Groove to indie and jazz performances.",
                "startTime": "2025-06-25T19:30",
                "endTime": "2025-06-25T22:00"
            },
            {
                "id": 8,
                "name": "3D Art Workshop",
                "banner": "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40",
                "description": "Learn sculpting in virtual space.",
                "startTime": "2025-06-26T10:00",
                "endTime": "2025-06-26T13:00"
            },
            {
                "id": 9,
                "name": "Night Sky Photography",
                "banner": "https://images.unsplash.com/photo-1515165562835-c1c4e1387a5b",
                "description": "Capture the Milky Way with guidance from pros.",
                "startTime": "2025-06-27T21:00",
                "endTime": "2025-06-27T23:59"
            }
        ]

        
        const now = new Date();
        
        const upcoming = [];
        const ongoing = [];
        const past = [];
        
        events.map(event => {
            const start = new Date(event.startTime)
            const end = new Date(event.endTime)
            
            if (start > now) upcoming.push(event)
            else if (start <= now && now <= end) ongoing.push(event)
            else past.push(event)
        })
        
        setUpcomingEvents(upcoming)
        setOngoingEvents(ongoing)
        setPastEvents(past)
    }, [])
    
    
    return (
        <div className="events">
            Ongoing events: {ongoingEvents.length}
            <br/>
            Upcoming events: {upcomingEvents.length}
            <br/>
            Past events: {pastEvents.length}
        
        </div>
    )
}

export default EventsLanding;