import React from 'react'

/**
 * @function Badge
 */
const Badge = (props) =>
{
    const icon = () =>
    {
        if (props.defaultIcon)
        {
            return props.defaultIcon;
        }

        return props.status
            ? props.successIcon
            : props.failIcon;
    };

    return  (
            <span className={ props.className }>
                { props.icon
                    ?  <i className={ `${ icon() } p-2` }></i>
                    : props.badgeName
                }
            </span>
    );
}
export default React.memo(Badge);
