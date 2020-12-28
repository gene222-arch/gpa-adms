import React,{ useState, useRef, useEffect } from 'react';
import { fetchReliefAsstLists, fetchRecipients, saveReliefAsst, renewReliefAsst, removeReliefAsst } from './services/Users/Volunteer'
import createFormFields from './configs/create_relief'
import AutoForm from './components/Forms/AutoForm'
import ReliefSentList from './components/Tables/ReliefSentList';
import * as Alert from './components/Helpers/Alert.js'


const VolunteerApp = () =>
{
    console.log('Render VolunteerApp');

    const [ reliefAsstLists, setReliefAsstLists ] = useState([]); // Display
    const [ reliefAsst, setReliefAsst ] = useState({}); // Update
    const [ recipients, setRecipients ] = useState([]); // Select options
    const [ errorMessages, setErrorMessages ] = useState({}); // Validation
    const [ navigate, setNavigate ] = useState('report-link'); // Navigation
    const [ loading, setLoading ] = useState(false); // Loading

// Pagination States
    const [ currentPage, setCurrentPage ] = useState(1); // Page = 1
    const [ dataCountPerPage ] = useState(2); // Page 1 = No. of Data = 2

// Refs
    const createRef = useRef('');
    const reportRef = useRef('');


/** * * * * * * * * *
 * * Database
 * * * * * * * * * */

    /**
     *
     */
    const getReliefAsstLists = async () =>
    {
        setLoading(true); // Loading

        const result = await fetchReliefAsstLists();
        result
            ? setReliefAsstLists(result)
            : setReliefAsstLists([])

        setLoading(false); // Loaded
    };

    /**
     *
     */
    const getRecipients = async () =>
    {
        const result = await fetchRecipients();
        result
            ? setRecipients(result)
            : setRecipients([]);
    }

    /**
     *
     * @param {*} payload
     */
    const handleOnStoreReliefAsst = async (payload) =>
    {
        const result = await saveReliefAsst(payload);
        if (result !== true)
        {
            setErrorMessages(result)
        }
        else
        {
            getReliefAsstLists();
            setErrorMessages({});
            Alert.onSuccess();
        }
    }

    /**
     *
     * @param {*} id
     */
    const handleOnEditReliefAsst = (id) =>
    {
        const findById = reliefAsstLists.find(reliefList => reliefList.id === id);
        console.log(findById);
        findById ? setReliefAsst(findById) : setReliefAsst({});
    }

    /**
     *
     * @param {*} payload
     */
    const handleOnUpdate = async (payload) =>
    {
        console.log(payload);
    }

    /**
     *
     * @param {*} id
     */
    const handleOnDelete = async (id) =>
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
        .then((result) => {
            if (result.isConfirmed)
            {
                if (removeReliefAsst(id))
                {
                    getReliefAsstLists();
                    Alert.onDelete();
                }
                else
                {
                    Alert.onError();
                }
            }
        });
    }


/** * * * * * * * * * * * * *
 * * Events
 * * * * * * * * * * * * * */

    /**
     *
     */
    const receivedReliefAsstEvent = () =>
    {
        Echo.channel('channelName')
            .listen('OnReceiveReliefAssistanceEvent', (e) =>
            {
                console.log(e.message)
                alert(e.message)
            });
    };


    /**
     * ! Add/Remove of class names
     */

    const onClickLink = (e) =>
    {
        let reportRefClassName = reportRef.current.className;
        let createRefClassName = createRef.current.className;
        const { name } = e.target;

        if (
            name === 'report-link' &&
            !(reportRefClassName).includes('active') &&
            (createRefClassName).includes('active')
            )
        {
            setNavigate('report-link');
            addClassActive(reportRef);
            removeClassActive(createRef);
        }
        if (name === 'create-relief-link')
        {
            setNavigate('create-relief-link');
            removeClassActive(reportRef);
            addClassActive(createRef);
        }
    }
    const addClassActive = (elem) =>  elem.current.className += ' active';
    const removeClassActive = (elem) => elem.current.className = 'nav-link';


/** * * * * * * * * * * * * *
 * * Pagination Functions
 * * * * * * * * * * * * * */

    //Pagination Functions and Variables
    const indexOfLastPage = currentPage * dataCountPerPage; // No of data per page =  (1 * 4) = 4
    const indexOfFirstPage = indexOfLastPage  - dataCountPerPage; // 4 - 4 = 0
    const currentPageData =  reliefAsstLists.slice(indexOfFirstPage, indexOfLastPage);

    const paginate = (pageNumber) =>  setCurrentPage(pageNumber);
    const nextPage = () => setCurrentPage(prevPageNumber => prevPageNumber + 1);
    const prevPage = () => setCurrentPage(prevPageNumber => prevPageNumber - 1 );


    /**
     * ? Side Effects
     */

    // Reset Error Messages on changed navigation
    useEffect(() =>
    {
        setErrorMessages({});
        getReliefAsstLists();
    }, [navigate])

    // Channels
    useEffect(() =>
    {
        receivedReliefAsstEvent();
        getRecipients();
    }, []);


    return (
        <div className="container-fluid">
            <div className="row justify-content-center">
                <div className="col col-xl-12">
                    <div className="card mt-2">
                        <div className="card-header">
                            <ul className="nav nav-tabs card-header-tabs">
                                <li className="nav-item">
                                    <a
                                        name='report-link'
                                        ref={ reportRef }
                                        onClick={ onClickLink }
                                        className='nav-link active'
                                        aria-current="true" href="#">Report</a>
                                </li>
                                <li className="nav-item">
                                    <a
                                        name='create-relief-link'
                                        ref={ createRef }
                                        onClick={ onClickLink }
                                        className='nav-link'
                                        href="#"
                                        tabIndex="-1"
                                        aria-disabled="true">Create Relief</a>
                                </li>
                            </ul>
                        </div>
                        <div className="card-body">
                            <h5 className="card-title text-center">Special title treatment</h5>
                            <p className="card-text text-center">With supporting text below as a natural lead-in to additional content.</p>
                            {
                                navigate === 'create-relief-link'
                                    ? <AutoForm
                                        form={ createFormFields }
                                        onSubmit={ handleOnStoreReliefAsst }
                                        errorMessages = { errorMessages }
                                        options={ recipients }
                                    />
                                    : <>
                                        <ReliefSentList
                                            reliefLists={ currentPageData }
                                            handleOnEdit = { handleOnEditReliefAsst }
                                            handleOnDelete = { handleOnDelete }
                                            loading = { loading }
                                            dataCountPerPage={ dataCountPerPage }
                                            totalCountOfData={ reliefAsstLists.length }
                                            paginate={ paginate }
                                            nextPage={ nextPage }
                                            prevPage={ prevPage }
                                            currentPage={ currentPage }
                                        />
                                    </>
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default React.memo(VolunteerApp);

/**
 * ? So when we are exporting an entire array of objects
 * ? then you can import it using any kind of names
 */
