import React, { useState, useEffect } from 'react'
import {
    fetchUserWithReliefAssistance,
    approveUserReliefAssistance,
    disApproveUserReliefAssistance,
    reliefAsstHasReceived,
    relieveReceivedReliefAsst,
    dispatchReliefAsst,
    removeReliefAssistance,
} from './services/Admin'
import AdminReliefAsstLists from './components/Tables/AdminReliefAsstLists'
import * as Alert from '../relief-goods/components/Helpers/Alert.js'

/**
 * Todo fix admin pagination
 */

const AdminApp = () =>
{
    const [ usersReliefLists, setUsersReliefLists ] = useState([]);
    const [ recipientId, setRecipientId ] = useState(null);
    const [ loading, setLoading ] = useState(false);

    const [ currentPage, setCurrentPage ] = useState(1);
    const [ dataCountPerPage ] = useState(2);
    const [ reliefListsTotalCount, setReliefListsTotalCount ] = useState(0);


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
    const getUsersWithReliefAsst = async () =>
    {
        setLoading(true);
        const result = await fetchUserWithReliefAssistance();

        if (result.length)
        {
            setUsersReliefLists(result)
            // Set pagination data count per page
            let totalReliefLists = result
                .map(res => res.relief_goods.length)
                .reduce((accu, cur) => accu + cur);

        setReliefListsTotalCount(totalReliefLists);
        }
        else
        {
            setUsersReliefLists([]);
        }
        setLoading(false);
    };

    /**
     * Approving a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */
    const onClickApproveReliefAsst = async (payload) =>
    {
        const result = await approveUserReliefAssistance(payload);

        result
            ? getUsersWithReliefAsst()
            : Alert.onError();
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

        result
            ? getUsersWithReliefAsst()
            : Alert.onError();
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
     * @param {*} payload
     */
    const onClickDispatchReliefAsst = async (payload) =>
    {
        const result = await dispatchReliefAsst(payload);
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
        const result = await removeReliefAssistance(payload);
        result
            ? getUsersWithReliefAsst()
            : Alert.onError();
    };


    /**
     * Pagination
     * Todo Fix Pagination
     */

    const indexOfLastPage = currentPage * dataCountPerPage; // 5, 10
    const indexOfFirstPage = indexOfLastPage - dataCountPerPage; // 1, 5
    const currentPageList = usersReliefLists.slice(indexOfFirstPage, indexOfLastPage);

    const paginate = (pageNumber) => setCurrentPage(pageNumber);
    const nextPage = (currentPageNumber) => setCurrentPage(prevPageNumber => prevPageNumber + 1);
    const prevPage = (currentPageNumber) => setCurrentPage(prevPageNumber => prevPageNumber - 1);


    /**
     * Events
     */

    const listenToNewReliefAsstEvent = () =>
    {
        Echo.private('admin.dashboard.relief-assistance-mngmt.volunteers.1')
            .listen('NewReliefAssistanceEvent', (response) =>
            {
                const fetch = async () =>
                {
                    const result = await fetchUserWithReliefAssistance();
                    setUsersReliefLists(result);
                };
                fetch();
            });
    };

    /**
     * ? Side Effects
     */

    useEffect(() =>
    {
        getUsersWithReliefAsst();
        listenToNewReliefAsstEvent();
    }, []);


    return (
        <div>
            <AdminReliefAsstLists
                usersReliefLists={ currentPageList }
                onClickApproveReliefAsst={ onClickApproveReliefAsst }
                onClickDisapproveReliefAsst={ onClickDisapproveReliefAsst }
                onClickReliefAsstHasReceived={ onClickReliefAsstHasReceived }
                onClickRelieveReceivedReliefAsst={ onClickRelieveReceivedReliefAsst }
                onClickDispatchReliefAsst= { onClickDispatchReliefAsst }
                onClickRemoveReliefAsst={ onClickRemoveReliefAsst }
                dataCountPerPage={ dataCountPerPage }
                totalCountOfData={ reliefListsTotalCount }
                paginate = { paginate }
                nextPage = { nextPage }
                prevPage = { prevPage }
                currentPage = { currentPage }
                loading={ loading }
                />
        </div>
    )
}

export default React.memo(AdminApp);
