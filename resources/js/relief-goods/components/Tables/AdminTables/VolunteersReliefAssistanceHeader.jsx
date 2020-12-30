import React from 'react'

const VolunteersReliefAssistanceLists = () =>
{
    return (
        <thead>
            <tr>
                <th>#</th>
                <th>Sponsor</th>
                <th>Relief Item</th>
                <th>Recipient</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    )
}

export default React.memo(VolunteersReliefAssistanceLists);
