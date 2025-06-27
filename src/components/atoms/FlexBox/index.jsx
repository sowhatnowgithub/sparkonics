import "./styles.scss"
import clsx from "clsx";

const FlexBox = ({
                     justify,
                     justifyBetween,
                     justifyEnd,
                     align,
                     alignEnd,
                     column,
                     className,
                     noShrink,
                     fullWidth,
                     autoWrap,
                     ...props
                 }) => {
    
    
    return (
        <div className={clsx(
            'sw-flexbox',
            column && 'sw-flexbox-column',
            autoWrap && 'sw-flexbox-wrap',
            justify && 'sw-flexbox-justify-center',
            justifyBetween && 'sw-flexbox-justify-between',
            justifyEnd && 'sw-flexbox-justify-end',
            align && 'sw-flexbox-align-center',
            alignEnd && 'sw-flexbox-align-end',
            fullWidth && 'sw-flexbox-full-width',
            noShrink && 'sw-flexbox-no-shrink',
            className
        )} {...props}></div>
    )
};


FlexBox.defaultProps = {
    className: '',
    column: false,
    justify: false,
    align: false,
    noShrink: false,
    justifyBetween: false,
    fullWidth: false,
    justifyEnd: false,
    alignEnd: false,
};

export default FlexBox;
