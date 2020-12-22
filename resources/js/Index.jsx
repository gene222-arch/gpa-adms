import React from 'react';
import ReactDOM from 'react-dom'
import App from './relief-goods/App'
import AdminApp from './relief-goods/AdminApp'

if (document.getElementById('relief'))
{
    ReactDOM.render(<App />, document.getElementById('relief'));
}

if (document.getElementById('volunteer-relief-assistance-mngmt'))
{
    ReactDOM.render(<AdminApp />, document.getElementById('volunteer-relief-assistance-mngmt'));
}

