import React from 'react'

const ErrorMessage = ({ message = '' }) =>
{
    console.log('Render Error Message')
    return (
        <div className='invalid-feedback'>
            { message }
        </div>
    )
}

export default React.memo(ErrorMessage)
