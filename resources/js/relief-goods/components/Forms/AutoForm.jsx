import React, { useState, useEffect } from 'react'
import Field from './Fields'
import Button from '../Buttons/Button'

/**
 * @function AutoForm
 * @param { form }
 */

const AutoForm = ({ form, onSubmit, errorMessages }) =>
{

    console.log('Render Auto Form');

    const [ fields, setFields ] = useState( form.fields.map( field => ({
        ...field,
        value: '',
    })));


    /**
     * @function handleOnChange
     * @param e
     */
    const handleOnChange = (e) =>
    {
        const { name, value } = e.target;
        const newData = fields.map(field =>
            field.name === name
                ? { ...field, value }
                : field);
        setFields(newData);
    };

    /**
     * @function handleOnSubmit
     * @param e
     */
    const handleOnSubmit = (e) =>
    {
        e.preventDefault();
        const formData = fields.reduce((fields, field) =>
        {
           return {  ...fields, [field.name] : field.value }
        }, {});

        onSubmit(formData);
        if (!Object.keys(errorMessages).length)
        {
            e.target.reset();
        }
    };


    return (
        <div>
            <form onSubmit={ handleOnSubmit }>
                { form.fields.map((field, key) => <Field
                        key={ key }
                        field={ field }
                        onChange={ handleOnChange }
                        errorMessages={ errorMessages }
                        />
                )}
                <Button
                    className='btn-success'
                    btnName='Submit'
                    />
            </form>
        </div>
    )
}

export default AutoForm;
