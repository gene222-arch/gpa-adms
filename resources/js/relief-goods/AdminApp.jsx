import React, { useState, useEffect } from 'react'
import {
    fetchUserWithReliefAssistance,
    approveUserReliefAssistance,
    disApproveUserReliefAssistance,
    reliefAsstHasReceived,
    relieveReceivedReliefAsst,
    dispatchReliefAsst,
    undispatchReliefAsst,
    removeReliefAssistance,
} from './services/Admin'
import AdminReliefAsstLists from './components/Tables/AdminTables/VolunteerReliefAsstLists'
import * as Alert from '../relief-goods/components/Helpers/Alert.js'
import Swal from 'sweetalert2';

/**
 * Todo fix admin pagination
 */

const AdminApp = () =>
{
    const [ usersReliefAssistance, setUsersReliefAssistance ] = useState([]);
    const [ errorMessages, setErrorMessages ] = useState({});
    //!end

    /**
     * Dispatch States
     */
    const [ dispatchUserId, setDispatchUserId ] = useState(0);
    const [ dispatchReliefGoodId, setDispatchReliefGoodId ] = useState(0);
    const [ dispatchRecipientId, setDispatchRecipientId ] = useState(0);
    const [ dispatchDate, setDispatchDate ] = useState('');
    //!end

    const [ loading, setLoading ] = useState(false);
    //!end

    /**
     * Modal States
     */
    const [ isModalOpen, setModalIsOpen ] = useState(false);

    /**
     * Pagination States
     */
    const [ currentPage, setCurrentPage ] = useState(1);
    const [ dataCountPerPage ] = useState(5);
    const [ reliefAssistanceCount, setReliefAssistanceCount ] = useState(0);
    //!end

    /*
    |--------------------------------------------------------------------------
    ? Database
    |--------------------------------------------------------------------------
    */

    /**
     * * Gettings users with relief assistance
     *
     * @returns @void
     */
    const getUsersWithReliefAsst = async (shouldLoad) =>
    {
        const result = await fetchUserWithReliefAssistance();
        const data = [];

        result.forEach(user => {
            result
                .map(userData => userData.relief_goods)
                .map(reliefGoods =>  // array
                    reliefGoods
                        .map(reliefGood =>
                            data.push(Object.assign(reliefGood, {
                                userId: user.id,
                                userName: user.name,
                            }))
                        )
                )
        });

        console.log(data);

        setUsersReliefAssistance(data)
        setReliefAssistanceCount(data.length);
    };

    // const prepareShouldLoad = (shouldLoad, callback) =>
    // {
    //     if (shouldLoad)
    //     {
    //         setLoading(true);
    //         callback();
    //         setLoading(false);
    //     }
    //     else
    //     {
    //         callback();
    //     }
    // };

    /**
     * Approving a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */
    const onClickApproveReliefAsst = async (payload) =>
    {
        const result = await approveUserReliefAssistance(payload);

        result === true
            ? getUsersWithReliefAsst()
            : Alert.onError(result);
    }

    /**
     * Disapproving a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */
    const onClickDisapproveReliefAsst = async (payload) =>
    {
        const result = await disApproveUserReliefAssistance(payload);

        result === true
            ? getUsersWithReliefAsst()
            : Alert.onError(result);
    }

    /**
     * On click Relief Asst is received
     *
     * @param {*} payload
     */
    const onClickReliefAsstHasReceived = async (payload) =>
    {
        const result = await reliefAsstHasReceived(payload);

        result === true
            ? getUsersWithReliefAsst()
            : Alert.onInfo(result);
    };

    /**
     * On click remove a user relief asst
     *
     * @param {*} payload
     */
    const onClickRelieveReceivedReliefAsst = async (payload) =>
    {
        const result = await relieveReceivedReliefAsst(payload);

        result === true
            ? getUsersWithReliefAsst()
            : Alert.onInfo(result);
    }

    /**
     *
     *
     * @param {*} payload
     */

    const onClickShowDispatchModal = (payload) =>
    {
        openModal();

        setDispatchUserId(payload.user_id);
        setDispatchRecipientId(payload.recipient_id);
        setDispatchReliefGoodId(payload.relief_good_id);
    };

    /**
     *
     * @param {*} e
     */
    const onChangeSetDispatchDate = (e) => setDispatchDate(e.target.value);

    /**
     *
     * @param {*} payload
     */
    const onClickDispatchReliefAsst = async (payload) =>
    {
        const result = await dispatchReliefAsst(payload);

        if (result === true)
        {
            getUsersWithReliefAsst();
            closeModal();
        }
        else
        {
            // Alert.onInfo(result);
            setErrorMessages(result);
        }
    }



    /**
     *
     * @param {*} payload
     */
    const onClickUndispatchReliefAsst = async (payload) =>
    {
        const result = await undispatchReliefAsst(payload);
        result === true
            ? getUsersWithReliefAsst()
            : Alert.onInfo(result);
    }
    /**
     * Removing a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */
    const onClickRemoveReliefAsst = async (payload) =>
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            })
            .then( async (result) => {
                if (result.isConfirmed)
                {
                    const res = await removeReliefAssistance(payload);
                    if (res)
                    {
                        Alert.onDelete();
                        await getUsersWithReliefAsst();
                    }
                    else
                    {
                        Alert.onError();
                    }
                }
            });
    };


    /**
     * Pagination
     * Todo Fix Pagination
     */

    const indexOfLastPage = currentPage * dataCountPerPage; // 1
    const indexOfFirstPage = indexOfLastPage - dataCountPerPage; // 1, 5
    const currentPageList = usersReliefAssistance.slice(indexOfFirstPage, indexOfLastPage);

    const paginate = (pageNumber) => setCurrentPage(pageNumber);

    /**
     * Modal
     */
    const openModal = () => setModalIsOpen(true);
    const closeModal = () => setModalIsOpen(false);

    /**
     * Events
     */

    const listenToNewReliefAsstEvent = () =>
    {
        Echo.private('admin.dashboard.relief-assistance-mngmt.volunteers.1')
            .listen('NewReliefAssistanceEvent', (response) =>
            {
                setUsersReliefAssistance(prevVal => [response, ...prevVal])
                console.log(response);
            });
    };


    /**
     * ? Side Effects
     */

    useEffect(() =>
    {
        getUsersWithReliefAsst(true);
    }, []);

    useEffect(() =>
    {
        listenToNewReliefAsstEvent();
    }, []);

    /**
     * Todo
     * Fix Pagination
     */

    return (
        <div>
            <div className="card">
                <div className="card-body">

                </div>
            </div>
            <AdminReliefAsstLists
                usersReliefAssistance={ currentPageList }
                onClickApproveReliefAsst={ onClickApproveReliefAsst }
                onClickDisapproveReliefAsst={ onClickDisapproveReliefAsst }
                onClickReliefAsstHasReceived={ onClickReliefAsstHasReceived }
                onClickRelieveReceivedReliefAsst={ onClickRelieveReceivedReliefAsst }
                onClickRemoveReliefAsst={ onClickRemoveReliefAsst }

                // Dispatching
                onClickShowDispatchModal= { onClickShowDispatchModal }
                dispatchUserId= {  dispatchUserId }
                dispatchReliefGoodId= { dispatchReliefGoodId }
                dispatchRecipientId= { dispatchRecipientId }
                dispatchDate={ dispatchDate }
                onChangeSetDispatchDate={ onChangeSetDispatchDate }
                onClickDispatchReliefAsst= { onClickDispatchReliefAsst }
                onClickUndispatchReliefAsst= { onClickUndispatchReliefAsst }

                // Error Messages
                errorMessages={ errorMessages }

                // Modal
                openModal= { openModal }
                closeModal= { closeModal }
                isModalOpen={ isModalOpen }
                loading={ loading }
            >
                {
                    (loading && totalCountOfData)
                        ?
                            <Pagination
                                dataCountPerPage={ dataCountPerPage }
                                totalCountOfData={ reliefAssistanceCount }
                                paginate = { paginate }
                                indexOfLastPage = { indexOfLastPage }
                                indexOfFirstPage = { indexOfFirstPage }
                                currentPage = { currentPage }
                            />
                        :
                            ''
                }
            </AdminReliefAsstLists>
        </div>
    )
}

export default React.memo(AdminApp);
