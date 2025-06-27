import "./styles.scss"
import clsx from "clsx";

const TextareaInput = ({ autoComplete, autoFocus, className, defaultValue, helperText, label, placeholder, rows, value, error, InputRef, InputProps, ...props }) => {
    
    return (
        <div className={clsx('sw-input', className)} {...props}>
            {label && <p className="sw-input-label">{label}</p>}
            <textarea
                placeholder={placeholder}
                autoComplete={autoComplete}
                autoFocus={autoFocus}
                defaultValue={defaultValue}
                value={value}
                className={clsx('sw-input-input', Boolean(error) && 'sw-input-shake')}
                ref={InputRef}
                rows={rows}
                {...InputProps}
            />
            {error && <p className="sw-input-error">{error}</p>}
            {helperText && <p className="sw-input-helper">{helperText}</p>}
        </div>
    )
}


export default TextareaInput;