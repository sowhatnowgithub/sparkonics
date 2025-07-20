import "./styles.scss"
import {useEffect} from "react";

const Modal = ({show, onClose, contentClass, title, ...props}) => {
    const keydownHandler = ({key}) => {
        switch (key) {
            case 'Escape':
                onClose();
                break;
            default:
        }
    };
    
    useEffect(() => {
        if (show) {
            document.addEventListener('keydown', keydownHandler);
        } else {
            return () => document.removeEventListener('keydown', keydownHandler);
        }
    }, [show])
    
    
    const onClickWrapper = (e) => {
        if (e.currentTarget === e.target) onClose();
    }
    
    
    return (
        <div className={`modal_wrapper ${show ? 'show' : ''}`} onClick={onClickWrapper}>
            <div className="modal_container">
                <div className="modal_title">
                    <div className="title">{title}</div>
                    <div className="close_icon" onClick={onClose}>
                        Close
                    </div>
                </div>
                <div className={`modal_content ${contentClass}`}>
                    {props.children}
                </div>
            </div>
        </div>
    )
}


export default Modal;