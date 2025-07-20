import React, {useMemo} from 'react';
import PropTypes from 'prop-types';

const tokens = {
    prefixAgo: null,
    prefixFromNow: null,
    suffixAgo: 'ago',
    suffixFromNow: '',
    inPast: 'any moment now',
    seconds: 'a few seconds',
    minute: 'a minute',
    minutes: '%d minutes',
    hour: 'an hour',
    hours: '%d hours',
    day: 'a day',
    days: '%d days',
    month: 'a month',
    months: '%d months',
    year: 'a year',
    years: '%d years',
    wordSeparator: ' ',
    numbers: []
};

// Parse ISO string or similar into Date object
function parseTimestring(input) {
    let str = input.trim()
        .replace(/\.\d+/, '')              // remove milliseconds
        .replace(/-/g, '/')
        .replace(/T/, ' ')
        .replace(/Z/, ' UTC')
        .replace(/([+-]\d\d):?(\d\d)/, ' $1$2')
        .replace(/([+-]\d\d)$/, ' $100');
    
    return new Date(str);
}

// Replace %d in tokens
function substituteToken(template, number) {
    const value = tokens.numbers?.[number] || number;
    return template.replace(/%d/i, value);
}

// Get relative time string like "2 days ago"
function getRelativeTime(date) {
    if (!(date instanceof Date)) return '';
    
    const delta = Date.now() - date.getTime();
    const prefix = delta < 0 ? tokens.prefixFromNow : tokens.prefixAgo;
    const suffix = delta < 0 ? tokens.suffixFromNow : tokens.suffixAgo;
    
    const seconds = Math.abs(delta) / 1000;
    const minutes = seconds / 60;
    const hours = minutes / 60;
    const days = hours / 24;
    const years = days / 365;
    
    let words = '';
    if (seconds < 45) words = substituteToken(tokens.seconds, Math.round(seconds));
    else if (seconds < 90) words = substituteToken(tokens.minute, 1);
    else if (minutes < 45) words = substituteToken(tokens.minutes, Math.round(minutes));
    else if (minutes < 90) words = substituteToken(tokens.hour, 1);
    else if (hours < 22) words = substituteToken(tokens.hours, Math.round(hours));
    else if (hours < 35) words = substituteToken(tokens.day, 1);
    else if (days < 25) words = substituteToken(tokens.days, Math.round(days));
    else if (days < 45) words = substituteToken(tokens.month, 1);
    else if (days < 365) words = substituteToken(tokens.months, Math.round(days / 30));
    else if (years < 1.5) words = substituteToken(tokens.year, 1);
    else words = substituteToken(tokens.years, Math.round(years));
    
    return [prefix, words, suffix].filter(Boolean).join(tokens.wordSeparator).trim();
}

// Format the date based on pattern
function formatDate(date, pattern) {
    if (!(date instanceof Date)) return '';
    if (pattern.toLowerCase() === 'iso8601') return date.toISOString();
    
    const parts = {
        M: date.getMonth() + 1,
        D: date.getDate(),
        H: date.getHours(),
        m: date.getMinutes(),
        s: date.getSeconds()
    };
    
    pattern = pattern.replace(/(M+|D+|H+|m+|s+)/g, (match) => {
        const key = match.slice(-1);
        return (match.length > 1 ? '0' : '') + parts[key].toString().padStart(2, '0');
    });
    
    pattern = pattern.replace(/(Y+)/g, (match) => {
        return date.getFullYear().toString().slice(-match.length);
    });
    
    return pattern;
}

// Main Component
export default function RelativeTime({value, titleFormat = 'iso8601', ...props}) {
    const date = useMemo(() => {
        if (value instanceof Date) return value;
        if (typeof value === 'string') return parseTimestring(value);
        if (typeof value === 'number') return new Date(value);
        return null;
    }, [value]);
    
    const humanReadable = useMemo(() => getRelativeTime(date), [date]);
    const machineReadable = useMemo(() => formatDate(date, 'iso8601'), [date]);
    const tooltip = useMemo(() => formatDate(date, titleFormat), [date, titleFormat]);
    
    if (!date || isNaN(date.getTime())) {
        return <span {...props}>Invalid date</span>;
    }
    
    return (
        <time title={tooltip} dateTime={machineReadable} {...props}>
            {humanReadable}
        </time>
    );
}

RelativeTime.propTypes = {
    value: PropTypes.oneOfType([
        PropTypes.instanceOf(Date),
        PropTypes.string,
        PropTypes.number
    ]).isRequired,
    titleFormat: PropTypes.string
};