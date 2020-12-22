import React from 'react'

const AlertMessage = ({ message, status }) =>
{
    return (
        <div className={ `alert alert-${ status }` }>
            { message }
        </div>
    )
}

export default AlertMessage
