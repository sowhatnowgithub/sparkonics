import {Modal} from "../../molecules/index.jsx";
import {useEffect, useState} from "react";
import {Button, DatetimeInput, ImageInput, TextareaInput, TextInput} from "../../atoms/index.jsx";
import BackendAPI from "../../../api.jsx";

const CreateModifyEventModal = ({show, onClose, onCreate, event, onModify}) => {
    const [eventDetails, setEventDetails] = useState({})
    const [errors, setErrors] = useState({})
    const [processingRequest, setProcessingRequest] = useState(false)
    
    useEffect(() => {
        if (event) {
            setEventDetails(event)
        }
    }, [show])
    
    
    const setValue = (field) => (event) => {
        setEventDetails(p => ({...p, [field]: event.target.value}))
    }
    const setError = (field) => (value) => {
        setErrors(p => ({...p, [field]: value}))
    }
    
    const submitForm = () => {
        let errorFree = true;
        if (eventDetails.banner === undefined || eventDetails.banner.trim() === '') {
            setError('banner')("Missing event banner");
            errorFree = false;
        }
        if (eventDetails.name === undefined || eventDetails.name.trim() === '') {
            setError('name')("Missing event name");
            errorFree = false;
        }
        if (eventDetails.description === undefined || eventDetails.description.trim() === '') {
            setError('description')("Missing event description");
            errorFree = false;
        }
        if (eventDetails.startTime === undefined || eventDetails.startTime.trim() === '') {
            setError('startTime')("Missing event start time");
            errorFree = false
        }
        if (eventDetails.endTime === undefined || eventDetails.endTime.trim() === '') {
            setError('endTime')("Missing event end time");
            errorFree = false
        }
        if (eventDetails.password === undefined || eventDetails.password.trim() === '') {
            setError('password')("Missing admin password");
            errorFree = false
        }
        
        if (errorFree === false) return;
        
        
        setProcessingRequest(true)
        if (event) {
            BackendAPI
                .post("/events/modify/", eventDetails)
                .then(data => onModify(data))
                .catch(err => alert(`Failed to modify - ${err}`))
                .finally(() => setProcessingRequest(false))
        } else {
            BackendAPI
                .post("/events/", eventDetails)
                .then(data => onCreate(data))
                .catch(err => alert(`Failed to add - ${err}`))
                .finally(() => setProcessingRequest(false))
        }
    }
    
    
    return (
        <Modal show={show} onClose={() => {
            setEventDetails({});
            setErrors({});
            onClose()
        }} title={event ? 'Modify event' : 'Create event'}>
            <ImageInput
                label={"Event banner"}
                imageURLSrc={eventDetails.banner}
                updateBanner={(url) => setValue("banner")({target: {value: url}})}
                error={errors.banner}
            />
            
            <TextInput
                label={"Event name"}
                value={eventDetails.name}
                placeholder={"Event name here"}
                type={'text'}
                error={errors.name}
                autoFocus
                onChange={(e) => {
                    if (errors.name && e.target.value.trim() !== '') setError("name")("");
                    setValue('name')(e)
                }}
            />
            <TextareaInput
                label={"Event description"}
                value={eventDetails.description}
                placeholder={"Event description here"}
                rows={5}
                error={errors.description}
                onChange={(e) => {
                    if (errors.description && e.target.value.trim() !== '') setError("description")("");
                    setValue('description')(e)
                }}
            />
            <DatetimeInput
                label={"Start time"}
                value={eventDetails.startTime}
                error={errors.startTime}
                onChange={(e) => {
                    if (errors.startTime && e.target.value.trim() !== '') setError("startTime")("");
                    setValue('startTime')(e)
                }}
            />
            <DatetimeInput
                label={"End time"}
                value={eventDetails.endTime}
                onChange={(e) => {
                    if (errors.endTime && e.target.value.trim() !== '') setError("endTime")("");
                    setValue('endTime')(e)
                }}
                error={errors.endTime}
                InputProps={{min: eventDetails.startTime, disabled: eventDetails.startTime === undefined}}
            />
            
            <TextInput
                label={"Admin password"}
                value={eventDetails.password}
                placeholder={"The secret password"}
                type={'password'}
                error={errors.password}
                onChange={(e) => {
                    if (errors.password && e.target.value.trim() !== '') setError("password")("");
                    setValue('password')(e)
                }}
            />
            
            <Button onClick={submitForm}
                    variant={"filled"}>{processingRequest ? (event ? 'Modifying event' : 'Adding event...') : (event ? "Modify event" : 'Create event')}</Button>
        </Modal>
    )
}

export default CreateModifyEventModal;