import React from 'react'
import ErrorMessage from '../Messages/ErrorMessage'

/**
 * @function Field
 * @param fields object
 * @param onChange event
 * @param errorMessages array
 * @param options
 */
const Field = ({field, onChange, errorMessages = {}, options = []}) =>
{
    console.log('Render Field');

    const { label, optionDefaultValue, ...attributes } = field;
    /**
     * To array the fieldName in the errorMessages object
     */
    const errorMessagesKeys = Object.keys(errorMessages);

    /**
     * ! Error Messages Configuration
     * @param elementName
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
                                    <option key={'uniqueKey'} value="">{ optionDefaultValue }</option>
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
                }
            })()}

            {/* Error Message */}
            <ErrorMessage message={ getErrMessage(attributes.name) }/>
        </div>
    )
}

export default React.memo(Field);
