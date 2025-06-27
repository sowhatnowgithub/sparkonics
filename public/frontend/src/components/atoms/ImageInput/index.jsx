import clsx from "clsx";
import "./styles.scss";
import BackendAPI from "../../../api.jsx";
import {useState} from "react";

const ImageInput = ({ imageURLSrc, className, updateBanner, error, label, ...props }) => {
    const [processing, setProcessing] = useState(false)
    
    const onFileUpload = (event) => {
        setProcessing(true)
        const file = event.target.files[0];
        
        const formData = new FormData();
        formData.append("image", file);
        
        
        BackendAPI
            .post(`/uploadImage/`, formData, {
                headers: {
                    "content-type": "multipart/form-data",
                },
            })
            .then(res => updateBanner(res))
            .catch(err => alert(`Failed to add - ${err}`))
            .finally(() => setProcessing(false))
    }
    
    if (!imageURLSrc) {
        return (
            <div className={clsx(`sw-input sw-input-image sw-input-image-empty`, className)} {...props}>
                {label && <p className="sw-input-label">{label}</p>}
                <label htmlFor="image-upload" className={clsx(Boolean(error) && 'sw-input-error')}>
                    {processing ? "upload in process..." : "Click to upload image"}
                </label>
                <input
                    id="image-upload"
                    accept="image/*"
                    type="file"
                    hidden
                    onChange={onFileUpload}
                    className={clsx('sw-input-input', Boolean(error) && 'sw-input-error')}
                />
                {error && <p className="sw-input-error">{error}</p>}
            </div>
        )
    }
    
    return (
        <div className={clsx('sw-input sw-input-image sw-input-image-with', className)} {...props}>
            {label && <p className="sw-input-label">{label}</p>}
            <label htmlFor="image-upload" className={clsx(Boolean(error) && 'sw-input-error')}>
                {processing ? "upload in process..." : "Click to upload image"}
            </label>
            <input
                id="image-upload"
                accept="image/*"
                type="file"
                hidden
                onChange={onFileUpload}
                className={clsx('sw-input-input', Boolean(error) && 'sw-input-error')}
            />
            <img
                src={imageURLSrc}
                alt={label}
            />
            {error && <p className="sw-input-error">{error}</p>}
        </div>
    )
}

export default ImageInput;