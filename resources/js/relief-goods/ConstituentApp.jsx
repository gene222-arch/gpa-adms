import React, { useState, useEffect } from 'react'
import { fetchAuthenticatedUser, fetchUserReceivedReliefAsstLists } from './services/Users/Constituent'
import  ReliefReceivedLists from '../relief-goods/components/Tables/ReliefReceivedLists'

const ConstituentApp = () =>
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
    const currentPageData = receivedReliefAsst.slice(indexOfFirstPage, indexOfLastPage);

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

        const result = await fetchUserReceivedReliefAsstLists();
        result
            ? setReceivedReliefAsst(result)
            : setReceivedReliefAsst([]);

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
        Echo.private('cons.relief-asst.receive.' + authenticatedUser.id)
            .listen('NewReliefAssistance', (reliefAsst) =>
            {
                console.log(reliefAsst);
                setReceivedReliefAsst(prevVal => [ ...prevVal, reliefAsst ]);

                alert('Successfully inserted')
            });
    };

    /**
     * Side effects
     */

    useEffect(() => {
        getUserReceivedReliefAsst();
        getAuthenticatedUser();
    }, []);

    useEffect(() =>
    {
        listenToNewReliefAsstEvent();
        console.log(authenticatedUser)
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

export default ConstituentApp
