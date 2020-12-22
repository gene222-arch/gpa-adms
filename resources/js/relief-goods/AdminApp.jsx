import React, { useState, useEffect } from 'react'
import {
    getUserWithReliefAssistance,
    approveUserReliefAssistance,
    disApproveUserReliefAssistance,
    reliefAsstHasReceived,
    removeReliefAssistance,
    relieveReceivedReliefAsst
} from './services/Admin'
import AdminReliefAsstLists from './components/Tables/AdminReliefAsstLists'
import * as Alert from '../relief-goods/components/Helpers/Alert.js'

/**
 * Todo fix admin pagination
 */

const AdminApp = () =>
{
    const [ usersReliefLists, setUsersReliefLists ] = useState([]);
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
     * * Fetching users with relief assistance
     *
     * @returns @void
     */
    const loadUsersWithReliefAsst = async () =>
    {
        setLoading(true);
        const result = await getUserWithReliefAssistance();

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

        console.log(result);
        setLoading(false);
    };

    /**
     * Approving a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */
    const approveUser = async (payload) =>
    {
        const result = await approveUserReliefAssistance(payload);
        result
            ? loadUsersWithReliefAsst()
            : Alert.onError();
    }

    /**
     * Disapproving a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */
    const disApproveUser = async (payload) =>
    {
        const result = await disApproveUserReliefAssistance(payload);
        result
            ? loadUsersWithReliefAsst()
            : Alert.onError();
    }

    const handleReliefAsstHasReceived = async (payload) =>
    {
        const result = await reliefAsstHasReceived(payload);
        result === true
            ? loadUsersWithReliefAsst()
            : Alert.onInfo(result);
    };

    const handleRelieveReceivedReliefAsst = async (payload) =>
    {
        const result = await relieveReceivedReliefAsst(payload);
        result === true
            ? loadUsersWithReliefAsst()
            : Alert.onInfo(result);
    }

    /**
     * Removing a user's relief assistance
     *
     * @param {*} payload
     * @returns @void
     */

    const handleRemoveReliefAsst = async (payload) =>
    {
        const result = await removeReliefAssistance(payload);
        result
            ? loadUsersWithReliefAsst()
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
     * ? Side Effects
     */

    useEffect(() =>
    {
        loadUsersWithReliefAsst();
    }, []);


    /**
     * ! Return Statement
     */

    return (
        <div>
            <AdminReliefAsstLists
                usersReliefLists={ currentPageList }
                approveUser={ approveUser }
                disApproveUser={ disApproveUser }
                handleReliefAsstHasReceived={ handleReliefAsstHasReceived }
                handleRelieveReceivedReliefAsst={ handleRelieveReceivedReliefAsst }
                handleRemoveReliefAsst={ handleRemoveReliefAsst }
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

export default AdminApp;
