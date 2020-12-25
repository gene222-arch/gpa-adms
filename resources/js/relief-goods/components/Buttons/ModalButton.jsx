import React from 'react'

/**
 * @function Button
 */
const ModalButton = React.forwardRef(( props, ref ) =>
{
    const icon = () =>
    {
        if (props.defaultIcon)
        {
            return props.defaultIcon;
        }

        return props.status
            ? `${ props.successIcon } text-success `
            : props.failIcon;
    };

    return  (
        <button
            ref={ ref }
            className={ `btn ${ props.className }` }
            data-toggle='modal'
            data-target={ props.target }
            onClick={ props.onClick }
            >
                { props.icon
                    ? <i className={ icon() }></i>
                    : props.btnName
                     }
            </button>
    );
})

export default React.memo(ModalButton);
