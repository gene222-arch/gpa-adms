import React from 'react'
import Button from '../Buttons/Button'
import ModalButton from '../Buttons/ModalButton'
import Pagination from './Pagination'


const ReliefReceivedLists = (props) =>
{
    console.log('Render Relief Sent List')

    return (
        <div>

            <div className="modal fade" id="showReliefGoodsInfo" data-backdrop="static" data-keyboard="false"   tabIndex="-1" aria-labelledby="showReliefGoodsLabel" aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h3 className="modal-title" id="showReliefGoodsLabel">Relief Assistance Info.</h3>
                            <button type="button" className="btn btn-default btn-close" data-dismiss="modal" aria-label="Close">
                                X
                            </button>
                        </div>
                        <div className="modal-body">
                            <div className="row">
                                <div className="col col-xl-12">
                                    <img src="../../../../../storage/ssr/loading.gif" className='img w-100' alt=""/>
                                </div>
                                <div className="col col-xl-12 row">
                                    <div className="col col-xl-4">
                                        <label>Product Name: </label>
                                        { props.reliefAsstInfo.name }
                                    </div>
                                    <div className="col col-xl-4">
                                        <label>Qty: </label>
                                        { props.reliefAsstInfo.quantity }
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" className="btn btn-primary">Understood</button>
                        </div>
                    </div>
                </div>
            </div>

            <div className="row d-flex float-right">
                <div className="col col-xl-10"></div>
                <div className="col col-xl-2">
                    <Button
                        className={ 'btn btn-outline-danger' }
                        icon={ true }
                        defaultIcon={ 'far fa-trash-alt' }
                    />
                </div>
            </div>
            <table className="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sponsor</th>
                        <th>Prepared at</th>
                        <th>Scheduled at</th>
                    </tr>
                </thead>

                <tbody>
                    {
                        props.isLoading
                            ?   <tr>
                                    <td colSpan='6'>
                                        <img src="../../../../../storage/ssr/loading.gif" className='img w-100' alt=""/>
                                    </td>
                                </tr>
                            : props.receivedReliefAsst.map((reliefList, index) => (
                                <tr key={ reliefList.id }>
                                    <td>{ index + 1 }</td>
                                    <td>
                                        {
                                            Array.isArray(reliefList.users)
                                                ? reliefList.users.map(user => user.name)
                                                : reliefList.userName
                                        }
                                    </td>
                                    <td>{ reliefList.created_at.slice(0, 10) }</td>
                                    <td>{ reliefList.pivot.dispatched_at ??= 'Soon' }</td>
                                    <td>
                                        <ModalButton
                                            className={ 'btn btn-info' }
                                            icon={ true }
                                            defaultIcon={ 'far fa-eye' }
                                            target={ '#showReliefGoodsInfo' }
                                            onClick={ () => props.onClickShowReliefAsstInfo(reliefList.id) }
                                        />
                                    </td>
                                </tr>
                        ))
                    }
                </tbody>
            </table>
            {
                !props.isLoading && props.totalCountOfData
                    ?   <Pagination
                            dataCountPerPage={ props.dataCountPerPage }
                            totalCountOfData={ props.totalCountOfData }
                            paginate={ props.paginate }
                            nextPage={ props.nextPage }
                            prevPage={ props.prevPage }
                            currentPage={ props.currentPage }
                        />
                    :   ''
            }
        </div>
    )
}

export default React.memo(ReliefReceivedLists);
