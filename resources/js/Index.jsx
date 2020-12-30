import React from 'react';
import ReactDOM from 'react-dom'
import VolunteerApp from './relief-goods/VolunteerApp'
import Recipient from './relief-goods/RecipientApp'
import AdminApp from './relief-goods/AdminApp'


/**
 * Admin Components in Laravel Blade
 */
if (document.getElementById('volunteer-relief-assistance-mngmt'))
{
    ReactDOM.render(<AdminApp />, document.getElementById('volunteer-relief-assistance-mngmt'));
}

/**
 * Volunteer Components
 */
if (document.getElementById('on-process-and-create-relief-asst'))
{
    ReactDOM.render(<VolunteerApp />, document.getElementById('on-process-and-create-relief-asst'));
}


/**
 * Recipient Components
 */
if (document.getElementById('my-received-relief-asst-lists'))
{
    ReactDOM.render(<Recipient />, document.getElementById('my-received-relief-asst-lists'));
}



