/**
 * @function payloadToFormData
 * @param {*} object
 */

export const toFormData = (object = {}, method = null) =>
{
    let formData = new FormData;

    for (const key in object)
    {
        if (object.hasOwnProperty(key))
        {
            formData.append(key, object[key])
        }
    }
    console.log(object)

    const imageValueType = typeof formData.get('image');

    if (imageValueType === 'string' || imageValueType === null)
    {
        formData.delete('image');
    }
    if (method)
    {
        formData.append('_method', method);
    }

    return formData;
};

/**
 * Route
 */

 export const route = (url) => url.replaceAll('.', '/');
