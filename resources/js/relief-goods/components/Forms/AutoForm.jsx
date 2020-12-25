import React, { useState, useEffect } from 'react'
import Field from './Fields'
import Button from '../Buttons/Button'

/**
 * @function AutoForm
 *
 * @param { form } object
 * @param { onSubmit } function
 * @param { errorMessages } object
 * @param { options } array
 */

const AutoForm = ({ form, onSubmit, errorMessages, options }) =>
{

    console.log('Render Auto Form');

    /**
     * Returns an array of objects
     */
    const [ fields, setFields ] = useState( form.fields.map( field => ({
        ...field,
        value: '',
    })));

    /**
     * @function handleOnChange
     *
     * @param e
     */
    const handleOnChange = (e) =>
    {
        const { name, value } = e.target;
        const newData = fields.map(field =>
            field.name === name
                ? { ...field, value }
                : field);
        console.log(`${name} = ${value}`)
        setFields(newData);
    };

    /**
     * @function handleOnSubmit
     *
     * @param e
     */
    const handleOnSubmit = (e) =>
    {
        e.preventDefault();
        const formData = fields.reduce((fields, field) =>
        {
           return {  ...fields, [field.name] : field.value }
        }, {});

        /**
         * @argument object
         */
        onSubmit(formData);

        if (! Object.keys(errorMessages).length)
        {
            /** Reset each field value as empty */
            setFields(form.fields.map( field => ({
                ...field,
                value: '',
            })));

            /** Reset the form */
            e.target.reset();
        }
    };


    return (
        <>
            <form onSubmit={ handleOnSubmit }>
            {
                fields.map((field, key) => // * Modified from form.fields.map => fields.map
                    <Field
                        key={ key }
                        field={ field }
                        onChange={ handleOnChange }
                        errorMessages={ errorMessages }
                        options={ options }
                    />
            )}
            <Button
                className='btn-success'
                btnName='Submit'
                />
            </form>
        </>
    )
}

export default AutoForm;
