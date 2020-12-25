import React,{ useState, useRef, useEffect } from 'react';
import { index, getConstituents, store, update, destroy } from './services/Users/Volunteer'
import createFormFields from './configs/create_relief'
import AutoForm from './components/Forms/AutoForm'
import ReliefSentList from './components/Tables/ReliefSentList';
import * as Alert from './components/Helpers/Alert.js'


const VolunteerApp = () =>
{
    console.log('Render VolunteerApp');

/**
 * ! States
 */
    const [ reliefLists, setReliefLists ] = useState([]); // Display
    const [ reliefList, setReliefList ] = useState({}); // Update
    const [ constituents, setConstituents ] = useState([]); // Select options
    const [ errorMessages, setErrorMessages ] = useState({}); // Validation
    const [ navigate, setNavigate ] = useState('report-link'); // Navigation
    const [ loading, setLoading ] = useState(false); // Loading
/**
 * ! Pagination States
 */
    const [ currentPage, setCurrentPage ] = useState(1); // Page = 1
    const [ dataCountPerPage ] = useState(2); // Page 1 = No. of Data = 2
/**
 * ! Refs
 */
    const createRef = useRef('');
    const reportRef = useRef('');




/** * * * * * * * * *
 * ! Database
 * * * * * * * * * */


    const getReliefLists = async () =>
    {
        setLoading(true); // Loading

        const result = await index();
        result
            ? setReliefLists(result)
            : setReliefLists([])

        setLoading(false); // Loaded
    };

    const getConstituentsLists = async () =>
    {
        const result = await getConstituents();
        result
            ? setConstituents(result)
            : setConstituents([]);
    }

    const handleOnStore = async (payload) =>
    {
        const result = await store(payload);
        if (result !== true)
        {
            setErrorMessages(result)
        }
        else
        {
            getReliefLists();
            setErrorMessages({});
            Alert.onSuccess();
        }
    }

    const handleOnEdit = (id) =>
    {
        const findById = reliefLists.find(reliefList => reliefList.id === id);
        console.log(findById);
        findById ? setReliefList(findById) : setReliefList({});
    }

    const handleOnUpdate = async (payload) =>
    {
        console.log(payload);
    }

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
                if (destroy(id))
                {
                    getReliefLists();
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
 * ! Pusher Notif
 * * * * * * * * * * * * * */

    const receivedReliefAsstEvent = () =>
    {
        // Route: channel.php -- for BroadCast channel
        // Echo.join('chat')
        //     .here((users) =>
        //     {
        //         console.log(users);
        //     })
        //     .joining((user) =>
        //     {
        //         console.log(`${ user.name } has joined`);
        //     })
        //     .leaving((user) =>
        //     {
        //         console.log(`${ user.name } has leaved`);
        //     });

        Echo.channel('geneTVChannel')
            .listen('ReceivedReliefAsstEvent', (e) =>
            {
                console.log(e.message)
                alert(e.message)
            });
    };


    /**
     * ! Add/Remove of class names
     */

    const handleLinkOnClick = (e) =>
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
 * ! Pagination Functions
 * * * * * * * * * * * * * */

    //Pagination Functions and Variables
    const indexOfLastPage = currentPage * dataCountPerPage; // No of data per page =  (1 * 4) = 4
    const indexOfFirstPage = indexOfLastPage  - dataCountPerPage; // 4 - 4 = 0
    const currentPageData =  reliefLists.slice(indexOfFirstPage, indexOfLastPage);

    const paginate = (pageNumber) =>  setCurrentPage(pageNumber);
    const nextPage = () => setCurrentPage(prevPageNumber => prevPageNumber + 1);
    const prevPage = () => setCurrentPage(prevPageNumber => prevPageNumber - 1 );

    /**
     * ! Side Effects
     */

    // Reset Error Messages on changed navigation
    useEffect(() =>
    {
        setErrorMessages({});
        getReliefLists();
    }, [navigate])

    // Channels
    useEffect(() =>
    {
        receivedReliefAsstEvent();
        getConstituentsLists();
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
                                        onClick={ handleLinkOnClick }
                                        className='nav-link active'
                                        aria-current="true" href="#">Report</a>
                                </li>
                                <li className="nav-item">
                                    <a
                                        name='create-relief-link'
                                        ref={ createRef }
                                        onClick={ handleLinkOnClick }
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
                                        onSubmit={ handleOnStore }
                                        errorMessages = { errorMessages }
                                        options={ constituents }
                                    />
                                    : <>
                                        <ReliefSentList
                                            reliefLists={ currentPageData }
                                            handleOnEdit = { handleOnEdit }
                                            handleOnDelete = { handleOnDelete }
                                            loading = { loading }
                                            dataCountPerPage={ dataCountPerPage }
                                            totalCountOfData={ reliefLists.length }
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
 *
 */
