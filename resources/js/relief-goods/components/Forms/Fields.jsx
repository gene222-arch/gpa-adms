import React from 'react'
import ErrorMessage from '../Messages/ErrorMessage'

/**
 * @function Field
 * @param fields array
 * @param onChange event
 * @param errorMessages array
 */
const Field = ({field, onChange, errorMessages = {}, options}) =>
{
    console.log('Render Field');

    const { label, ...attributes } = field;
    const errorMessagesKeys = Object.keys(errorMessages);

    /**
     * ! Error Messages Configuration
     */
    const isErrorExists = (elementName) => errorMessagesKeys.find(errKey => errKey === elementName);

    /**
     * Setting the class name as invalid if error key match the elementName
     */
    const setIsInvalid = (elementName) =>
    {
        return isErrorExists(elementName)
            ? 'form-control is-invalid'
            : 'form-control';
    };

    /**
     * Fetching the corresponding error message
     *
     * @param {} elementName
     */
    const getErrMessage = (elementName) =>
    {
        const errKey = isErrorExists(elementName);
        return errKey ? errorMessages[errKey] : '';
    };


    return (
        <div className='form-group'>

            {/* Label */}
            <label className='form-label' htmlFor={ label }>{ label }</label>

            {/* Input element */}
            {(() => {
                switch (attributes.type)
                {
                    case 'textarea':
                            return <textarea { ...attributes }
                                className={ setIsInvalid(attributes.name) }
                                onChange={ onChange }>{ attributes.placeholder }</textarea>
                        break;
                    case 'select':
                            return (
                                <select { ...attributes }
                                    className={ setIsInvalid(attributes.name) }
                                    onChange={ onChange }>
                                    <option key={'uniqueKey'} value="">{ attributes.optionDefault }</option>
                                    {
                                        options.map(option => (
                                            <option key={option.id} value={ option.id }> { option.name } </option>
                                        ))
                                    }
                                </select>
                            )
                        break;

                    default:
                        return <input { ...attributes }
                            className={ setIsInvalid(attributes.name) }
                            onChange={ onChange }/>
                        break;
                }
            })()}

            {/* Error Message */}
            <ErrorMessage message={ getErrMessage(attributes.name) }/>
        </div>
    )
}

export default React.memo(Field);
