import React, { useState } from 'react'

const Pagination = (props) =>
{
    console.log('Render PAginateion');
    console.log(`First: ${ props.indexOfFirstPage } - Last: ${props.indexOfLastPage}`);

    const [ activePage, setActivePage ] = useState(1);
    let pageNumbers = [];

    for (let index = 1; index <= Math.ceil(props.totalCountOfData / props.dataCountPerPage); index++)
    {
        pageNumbers.push(index);
    }

    if (activePage === (props.indexOfFirstPage + 1)/props.dataCountPerPage)
    {
        pageNumbers = pageNumbers.slice(0, 10);
    }

    if (activePage === (props.indexOfLastPage/props.dataCountPerPage))
    {
        pageNumbers = pageNumbers.slice(activePage, activePage + 10);
    }


    const nextPage = () => {
        props.paginate(props.currentPage + 1)
        setActivePage(props.currentPage + 1);
    };
    const prevPage = () => {
        props.paginate(props.currentPage - 1)
        setActivePage(props.currentPage - 1);
    };
    console.log(activePage);

    const isPageNumberEmpty = () => Boolean(!pageNumbers.length);
    const isLastPage = () => props.currentPage === props.indexOfLastPage || isPageNumberEmpty() ? 'disabled' : '';
    const isFirstPage = () => props.currentPage === props.indexOfFirstPage || isPageNumberEmpty() ? 'disabled' : '';
    const isCurrentPage = (pageNumber) => pageNumber === activePage ? 'active' : '';

    return (
        <nav aria-label="">
            <ul className="pagination">
                <li className={ `page-item ${ isFirstPage() }` }>
                    <a
                        onClick={ () => prevPage() }
                        className='page-link'
                        href="#!"
                        tabIndex="-1"
                        aria-disabled="true">Previous</a>
                </li>
                { pageNumbers.map(pageNumber => (
                    <li className={ `page-item ${ isCurrentPage(pageNumber) }` } key={ pageNumber }>
                        <a
                            onClick={() => {
                                props.paginate(pageNumber)
                                setActivePage(pageNumber);
                            }}
                            href="#!"
                            className='page-link'>
                            { pageNumber }
                        </a>
                    </li>
                ))}
                <li className={ `page-item ${ isLastPage() } ` }>
                    <a
                        onClick={ () => nextPage() }
                        className='page-link'
                        href="#!">Next</a>
                </li>
            </ul>
        </nav>
    )

};

export default Pagination
