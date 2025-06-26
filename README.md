# sparkonics


#  Sparkonics API Documentation

# Events API documentation
The **Sparkonics Events API** allows you to add, fetch, modify, and delete event data using simple GET requests with query parameters.

---

## 📦 Event Object Structure

```json
{
  "EventId": 1,
  "EventName": "Summer Kickoff",
  "EventDescription": "A fun festival to celebrate the start of summer with music, food, and games.",
  "EventStartTime": "2025-06-20 14:00:00",
  "EventEndTime": "2025-06-20 18:00:00",
  "EventDomains": "Music, Food, Games",
  "EventBanner": "https://example.com/banner.jpg",
  "EventStatus": "Active",
  "EventRegisterLink": "https://example.com/register"
}
```
## 🎯 EventStatus Accepted Values

- `Active`
- `Close`
- `Register`

## 🔗 API Base URL

http://localhost:1978

---

## 📚 API Endpoints Overview

| Endpoint                  | Description        | Method | Example                        |
|---------------------------|--------------------|--------|--------------------------------|
| `/api/events`             | Get all events     | GET    | `/api/events`                  |
| `/api/events/{id}`        | Get event by ID    | GET    | `/api/events/1`                |
| `/api/events/add`         | Add a new event    | GET    | `/api/events/add?...`          |
| `/api/events/modify`      | Modify event by ID | GET    | `/api/events/modify?...`       |
| `/api/events/delete/{id}` | Delete event by ID | GET    | `/api/events/delete/1`         |

## ✅ Required Fields for `/add`

The following fields are required when adding an event:  
`EventName`, `EventDescription`, `EventStartTime`, `EventEndTime`, `EventDomains`, `EventBanner`, `EventStatus`, `EventRegisterLink`

---

## 🔧 Optional Fields for `/modify`

To modify an event, you **must** include:  
`EventId`

You may also include one or more of the following:  
`EventName`, `EventDescription`, `EventStartTime`, `EventEndTime`, `EventDomains`, `EventBanner`, `EventStatus`, `EventRegisterLink`


