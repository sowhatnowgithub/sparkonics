import "./styles.scss"
import clsx from "clsx";

const TextInput = ({ autoComplete, autoFocus, className, defaultValue, helperText, label, placeholder, type, value, error, InputRef, InputProps, ...props }) => {
    
    return (
        <div className={clsx('sw-input', className)} {...props}>
            {label && <p className="sw-input-label">{label}</p>}
            <input
                placeholder={placeholder}
                type={type}
                autoComplete={autoComplete}
                autoFocus={autoFocus}
                defaultValue={defaultValue}
                value={value}
                className={clsx('sw-input-input', Boolean(error) && 'sw-input-shake')}
                ref={InputRef}
                {...InputProps}
            />
            {error && <p className="sw-input-error">{error}</p>}
            {helperText && <p className="sw-input-helper">{helperText}</p>}
        </div>
    )
}


export default TextInput;