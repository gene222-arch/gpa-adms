import { toFormData, route } from '../../components/Helpers/FormData.js'
import Axios from 'axios'

export const fetchAuthenticatedUser = async () =>
{
    return await Axios.get('/auth-user')
        .then(res => res.data)
        .catch(err => err.response.data);
};

export const fetchReceivedReliefAsstLists = async () =>
{
    return await Axios.get(route('/rcpt.relief-asst.receive'))
        .then(res => res.data)
        .catch(err => err.response.data)
};

