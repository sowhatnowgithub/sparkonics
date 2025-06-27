# sparkonics


# Project Dependencies

This project uses the following dependencies:
You don't have specifically install these seperately most of them are included when installed php and openswoole extension
- **PHP 8.4** or higher
- **OpenSwoole** (with Coroutines and SSL support and curl and mysql)
- **PDO SQLite** extension
- **PDO MySQL** extension
- **cURL** PHP extension
## installation guide
With mac os, gotta build from source openswoole and set up CPPflags and some tools have to be installed
Detailed guide available in openswoole docs
```
#add this into your bash to let the openswoole c installation smooth
export CPPFLAGS="-I$(brew --prefix brotli)/include"
export LDFLAGS="-L$(brew --prefix brotli)/lib"

export CPPFLAGS="-I/opt/homebrew/opt/pcre2/include"
export LDFLAGS="-L/opt/homebrew/opt/pcre2/lib"
export PKG_CONFIG_PATH="/opt/homebrew/opt/pcre2/lib/pkgconfig"

```
‼️Pecl Installation didn't work in macOs for openswoole.

## Basic set-up guide
Clone the repo,
and run the following
```
composer install
composer dump-autoload 
```

## Docker Container 

 **Docker For linux/arm**
```
docker pull sowhatnowdocker/sparkonics-event-api:latest 
docker run -p 1978:1978 sowhatnowdocker/sparkonics-event-api:latest
```
 **Docker For linux/amd**
```
docker pull sowhatnowdocker/sparkonics-event-api:amd64v1
docker run -p 1978:1978 sowhatnowdocker/sparkonics-event-api:amd64v1
```

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

## Developments

--Planning to implement a image api endpoint too, with efficient compresion of GET request and Responses




