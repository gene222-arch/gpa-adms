import React from 'react';
import ReactDOM from 'react-dom'
import VolunteerApp from './relief-goods/VolunteerApp'
import ConstituentApp from './relief-goods/ConstituentApp'
import AdminApp from './relief-goods/AdminApp'

if (document.getElementById('relief'))
{
    ReactDOM.render(<VolunteerApp />, document.getElementById('relief'));
}

if (document.getElementById('my-received-relief-asst-lists'))
{
    ReactDOM.render(<ConstituentApp />, document.getElementById('my-received-relief-asst-lists'));
}

if (document.getElementById('volunteer-relief-assistance-mngmt'))
{
    ReactDOM.render(<AdminApp />, document.getElementById('volunteer-relief-assistance-mngmt'));
}

