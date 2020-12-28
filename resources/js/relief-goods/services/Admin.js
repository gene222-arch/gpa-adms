import Axios from "axios";
import Swal from 'sweetalert2';
import { toFormData, route } from '../components/Helpers/FormData.js'

/**
 * * Fetch all user who have given relief assistance
 *
 */
export const fetchUserWithReliefAssistance = async () =>
{
    return await Axios.get(route('/admin.dashboard.relief-assistance-mngmt.volunteers.1'))
        .then(res => res.data)
        .catch(err => err.response.data);
};


/**
 * * Approve the relief assitance of the user
 *
 * @param {*} payload
 */
export const approveUserReliefAssistance = async (payload) =>
{
    return await Axios.post(route('/admin.dashboard.relief-assistance-mngmt.volunteers.approve'),
        toFormData(payload, 'PUT')
    )
        .then(res => {
            console.log(res.data)
            return true;
        })
        .catch(err => console.error(err.response.data))

};


/**
 * * Disapprove the relief assitance of the user
 *
 * @param {*} payload
 */
export const disApproveUserReliefAssistance = async (payload) =>
{
    return await Axios.post(route('/admin.dashboard.relief-assistance-mngmt.volunteers.disapprove'),
        toFormData(payload, 'PUT')
    )
        .then(res => {
            console.log(res.data)
            return true;
        })
        .catch(err => console.error(err.response.data))

};


/**
 *
 * @param {*} payload
 */
export const removeReliefAssistance = async (payload) =>
{
    return await Axios.post(route('/admin.dashboard.relief-assistance-mngmt.volunteers'),
    toFormData(payload, 'DELETE'))
        .then(res => true)
        .catch(err => console.error(err.response.data))
};

/**
 *
 * @param {*} payload
 */
export const reliefAsstHasReceived = async (payload) =>
{
    return await Axios.post(route('/admin.dashboard.relief-assistance-mngmt.volunteers.receive'),
    toFormData(payload, 'PUT'))
        .then(res => true)
        .catch(err => err.response.data.message)
}

/**
 *
 * @param {*} payload
 */
export const relieveReceivedReliefAsst = async (payload) =>
{
    return await Axios.post(route('/admin.dashboard.relief-assistance-mngmt.volunteers.relieve'),
    toFormData(payload, 'PUT'))
        .then(res => true)
        .catch(err => err.response.data.message)
}

/**
 *
 * @param {*} payload
 */
export const dispatchReliefAsst = async (payload) =>
{
    return await Axios.post(route('/admin.dashboard.relief-assistance-mngmt.volunteers.dispatch'),
    toFormData(payload, 'PUT'))
        .then(res => true)
        .catch(err => err.response.data.message);
};
