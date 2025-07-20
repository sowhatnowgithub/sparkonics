import {useState} from "react";

const Image = ({src, alt, ...props}) => {
    const [imageSrc, setImageSrc] = useState(src)
    
    const placeholderImageURL = "https://placehold.co/600x400/?text=Coming+Soon"
    
    const onImageLoadFail = () => {
        setImageSrc(placeholderImageURL)
    }
    
    
    return (
        <img
            src={imageSrc}
            alt={alt}
            onError={onImageLoadFail}
            {...props}
        />
    )
}

export default Image;