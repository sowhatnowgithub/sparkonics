import clsx from "clsx";

const DatetimeInput = ({className, defaultValue, helperText, label, value, error, InputRef, InputProps, ...props}) => {
    
    return (
        <div className={clsx('sw-input', className)} {...props}>
            {label && <p className="sw-input-label">{label}</p>}
            <input
                type="datetime-local"
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


export default DatetimeInput;