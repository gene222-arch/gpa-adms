import React from 'react'

const Pagination = ({ dataCountPerPage,  totalCountOfData, paginate, nextPage, prevPage, currentPage }) =>
{
    const pageNumbers = [];

    for (let index = 1; index <= Math.ceil(totalCountOfData / dataCountPerPage); index++)
    {
        pageNumbers.push(index)
    }

    const lastPageNum = () => pageNumbers[pageNumbers.length - 1];
    const isPageNumberEmpty = () => Boolean(!pageNumbers.length);
    const isLastPage = () => currentPage === lastPageNum() || isPageNumberEmpty() ? 'disabled' : '';
    const isFirstPage = () => currentPage === 1 || isPageNumberEmpty() ? 'disabled' : '';
    const isCurrentPage = (pageNumber) => pageNumber === currentPage ? 'active' : '' ;
    const toFirstPageOnPrevious = (currentPage) => currentPage === lastPageNum() ? paginate(lastPageNum()) : '';
    const toLastPageOnNext = (currentPage) => currentPage === 1 ? paginate(1) : '';

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
                            onClick={() => paginate(pageNumber)}
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
