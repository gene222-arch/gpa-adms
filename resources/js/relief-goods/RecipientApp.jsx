import React, { useState, useEffect } from 'react'
import { fetchAuthenticatedUser, fetchReceivedReliefAsstLists } from './services/Users/Recipient'
import  ReliefReceivedLists from './components/Tables/ReliefReceivedLists'

const RecipientApp = () =>
{

    const [ authenticatedUser, setAuthenticatedUser ] = useState({});
    const [ receivedReliefAsst, setReceivedReliefAsst ] = useState([]);
    const [ reliefAsstInfo, setReliefAsstInfo ] = useState({});
    const [ isLoading, setIsLoading ] = useState(false);


    /**
     * Pagination
     */

    const [ currentPage, setCurrentPage ] = useState(1);
    const [ dataCountPerPage, setDataCountPerPage ] = useState(5);


    const indexOfLastPage = currentPage * dataCountPerPage;
    const indexOfFirstPage = indexOfLastPage -  dataCountPerPage;
    const currentPageData = receivedReliefAsst
        ? receivedReliefAsst.slice(indexOfFirstPage, indexOfLastPage)
        : [];

    const paginate = (pageNumber) => setCurrentPage(pageNumber);
    const nextPage = () => setCurrentPage( prevPageNumber => prevPageNumber + 1);
    const prevPage = () => setCurrentPage( prevPageNumber => prevPageNumber - 1);


    /*
    |--------------------------------------------------------------------------
    ? Database
    |--------------------------------------------------------------------------
    */

   const getAuthenticatedUser = async () =>
   {
       const result = await fetchAuthenticatedUser();
       result
           ? setAuthenticatedUser(result)
           : setAuthenticatedUser({});
   }

    const getUserReceivedReliefAsst = async () =>
    {
        setIsLoading(true);

        const result = await fetchReceivedReliefAsstLists();
        result
            ? setReceivedReliefAsst(result)
            : setReceivedReliefAsst([]);
        console.log(result)
        setIsLoading(false);
    }


    /*
    |--------------------------------------------------------------------------
    ? Functions
    |--------------------------------------------------------------------------
    */
    const onClickShowReliefAsstInfo = (id) =>
    {
        const result = currentPageData.find(reliefGood => reliefGood.id === id)
        result
            ? setReliefAsstInfo(result)
            : setReliefAsstInfo({});
    };


    /*
    |--------------------------------------------------------------------------
    ? Laravel - Events
    |--------------------------------------------------------------------------
    */

    const listenToNewReliefAsstEvent = () =>
    {
        Echo.private(`rcpt.relief-asst.receive.${ authenticatedUser.id }`)
            .listen('NewReliefAssistanceEvent', (reliefAsst) =>
            {
                setReceivedReliefAsst(prevVal => [ ...prevVal, reliefAsst ]);
            });
    };

    const listenToRemoveReliefAsstEvent = () =>
    {
        Echo.private(`rcpt.relief-asst.receive.${ authenticatedUser.id }`)
            .listen('OnRemoveReliefAssistanceEvent', (result) =>
            {
                setReceivedReliefAsst(prevVal => prevVal.filter(
                    reliefAsst => reliefAsst.pivot.relief_good_id != result.relief_good_id));
            });
    }

    const listenToDispatchReliefAsstEvent = () =>
    {
        Echo.private(`rcpt.relief-asst.receive.${ authenticatedUser.id }`)
            .listen('OnDispatchReliefAssistanceEvent', (result) =>
            {
                const newData = receivedReliefAsst.map(data =>
                {
                    if ( data.id === result.relief_good_id)
                    {
                        data.pivot.sent_at = result.sent_at;
                        console.log(data);
                    }
                    return data;
                });

                setReceivedReliefAsst(newData);
            });
    }

    /**
     * Side effects
     */

    useEffect(() => {
        getUserReceivedReliefAsst();
        getAuthenticatedUser();
    }, []);

    /**
     * * Events
     */
    useEffect(() =>
    {
        listenToNewReliefAsstEvent();
        listenToRemoveReliefAsstEvent();
        listenToDispatchReliefAsstEvent();
    }, [authenticatedUser]);


    return (
        <div>
            <div className="card">
                <div className="card-body">
                    <ReliefReceivedLists
                        receivedReliefAsst={ currentPageData }
                        onClickShowReliefAsstInfo={ onClickShowReliefAsstInfo }
                        reliefAsstInfo={ reliefAsstInfo }
                        dataCountPerPage={ dataCountPerPage }
                        totalCountOfData={ receivedReliefAsst.length }
                        currentPage={ currentPage }
                        paginate={ paginate }
                        nextPage={ nextPage }
                        prevPage={ prevPage }
                        isLoading = { isLoading }
                    />
                </div>
            </div>
            <div className="card">
                <div className="card-body">

                </div>
            </div>
        </div>
    )
}

export default RecipientApp
