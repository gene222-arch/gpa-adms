import React from 'react'

const ModalButton = React.forwardRef(( props, ref ) =>
    (
        <button
            ref={ ref }
            className={ `btn ${ props.className }` }
            onClick={ props.onClick }
            data-toggle='modal'
            data-target={ `#${ props.target }` }
            >
            <i className={ `far fa-${ props.action }` }></i> </button>
    ));

export default React.memo(ModalButton);
