import {useEffect, useState} from "react";
import PropTypes from "prop-types";
import "./styles.scss"

const ProgressBar = ({usingCustom, progress}) => {
    const [scrollProgress, setScrollProgress] = useState(0)
    
    const updateScrollProgress = () => {
        const scrollTop = window.scrollY;
        const docHeight = document.body.scrollHeight - window.innerHeight;
        setScrollProgress(scrollTop / docHeight * 100)
    }
    
    useEffect(() => {
        if (!usingCustom) {
            window.addEventListener("scroll", updateScrollProgress)
            updateScrollProgress()
        }
        
        return () => window.removeEventListener("scroll", updateScrollProgress)
    }, [])
    
    
    return (
        <div className="progressbar" style={{width: `${usingCustom ? progress : scrollProgress}%`}}></div>
    )
}

ProgressBar.defaultProps = {
    usingCustom: false,
    progress: 0,
}

ProgressBar.propTypes = {
    usingCustom: PropTypes.bool,
    progress: PropTypes.number,
}


export default ProgressBar;