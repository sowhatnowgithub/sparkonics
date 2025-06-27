import "./styles.scss"


const Button = ({ variant, onClick, className, withShadow, ...props }) => {
  
    return (
        <button className={`sw-button sw-button-${variant || 'default'} ${withShadow && 'sw-button-shadow'} ${className}`} onClick={onClick}>
            {props.children}
        </button>
    )
}

export default Button;