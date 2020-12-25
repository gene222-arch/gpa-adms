import Axios from "axios";
import Swal from 'sweetalert2';
import { toFormData, route } from '../../components/Helpers/FormData.js'


/**
 * ! GET METHODS
 */

/**
 * Fetch a lists
 */
export const index = async () =>
{
    return await Axios.get(route('/vol.relief-assistance'))
        .then(res => res.data)
        .catch(err => err.response.data);
};

export const getConstituents = async () =>
{
    return await Axios.get(route('/vol.relief-assistance.constituents-lists'))
        .then(res => res.data)
        .catch(err => err.response.data);
}


/**
 * ! POST METHODS
 */

/**
 * Store
 * @param {*} payload
 */
export const store = async (payload) =>
{
    console.log(payload);
    return await Axios.post(route('/vol.relief-assistance.donate'), toFormData(payload))
        .then(res => true)
        .catch(err => {
            if (err.response.status === 401)
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `${ err.response.data.message }`,
                    footer: '<a href>Why do I have this issue?</a>'
                  });

                return false;
            }
            return err.response.data;
        });
};


/**
 * ! PUT/PATCH METHODS
 */


/**
 * Update
 * @param {*} payload
 */
export const update = async (payload) =>
{
    return await Axios.post(`/vol.relief-assistance?id=${ payload.id }`, toFormData(payload, 'PUT'))
        .then(res => console.log(res))
        .catch(err => console.error(err.response.data));
};



/**
 * ! DELETE METHODS
 */

/**
 * Delete
 * @param {*} id
 */
export const destroy = async (id) =>
{
    return await Axios.delete(`/vol.relief-assistance?id=${ id }`,)
        .then(res => true)
        .catch(err => err.response.data);
};
