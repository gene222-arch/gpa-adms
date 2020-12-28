import React from 'react'
import Button from '../Buttons/Button'
import Badge from '../Badge/Badge'
import Pagination from './Pagination';

const AdminReliefAsstLists = (props) =>
{

    const isApproved = (approve) => approve ? 'default' : '';
    const isCollected = (collect) => collect ? 'Collected' : 'Collect';
    const btnClassOnCollect = (isCollected) => isCollected ? 'btn-warning' : 'btn-outline-dark';

    return (
        <div>
            <table className="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>To</th>
                        <th>Status</th>
                        <th colSpan='4'>Action</th>
                    </tr>
                </thead>

                <tbody>
                {
                    props.loading
                        ?   <tr >
                                <td colSpan='6'>
                                    <img src="../../../../../storage/ssr/loading.gif" className='img w-100' alt=""/>
                                </td>
                            </tr>
                        : props.usersReliefLists.map( user =>
                        (
                            user.relief_goods.map( reliefGood =>
                            (
                                <tr key={ reliefGood.id }>
                                    <td>{ user.id } </td>
                                    <td>{ user.name }</td>
                                    <td>{ reliefGood.category }</td>
                                    <td>{ reliefGood.name }</td>
                                    <td>{ reliefGood.to }</td>
                                    <td>
                                        <Badge
                                            className={ isApproved(reliefGood.pivot.is_sent) }
                                            icon={ true }
                                            successIcon={ 'far fa-thumbs-up fa-2x' }
                                            failIcon={ 'fas fa-spinner fa-2x' }
                                            status={ reliefGood.pivot.is_sent }
                                        />
                                    </td>
                                    <td>
                                        {
                                            !reliefGood.pivot.is_approved
                                                ? <Button
                                                    className={ 'btn btn-outline-success' }
                                                    onClick={ () => props.onClickApproveReliefAsst(
                                                    {
                                                        user_id: reliefGood.pivot.user_id,
                                                        relief_good_id: reliefGood.pivot.relief_good_id,
                                                    })}
                                                    btnName={ 'Approve' }
                                                />
                                                : <Button
                                                    className={ 'btn btn-warning' }
                                                    onClick={ () => props.onClickDisapproveReliefAsst(
                                                    {
                                                        user_id: reliefGood.pivot.user_id,
                                                        relief_good_id: reliefGood.pivot.relief_good_id,
                                                    })}
                                                    btnName={ 'Disapprove' }
                                            />
                                        }
                                    </td>
                                    <td>
                                        {
                                            !reliefGood.pivot.is_received
                                                ? <Button
                                                    className={ 'btn-outline-dark' }
                                                    btnName={ 'Collect' }
                                                    onClick={ () => props.onClickReliefAsstHasReceived(
                                                    {
                                                        user_id: reliefGood.pivot.user_id,
                                                        relief_good_id: reliefGood.pivot.relief_good_id,
                                                    })}
                                                />
                                                :  <Button
                                                        className={ 'btn-warning' }
                                                        btnName={ 'Collected' }
                                                        onClick={ () => props.onClickRelieveReceivedReliefAsst(
                                                        {
                                                            user_id: reliefGood.pivot.user_id,
                                                            relief_good_id: reliefGood.pivot.relief_good_id,
                                                        })}
                                                    />
                                        }
                                    </td>
                                    <td>
                                        {
                                            <Button
                                                className={ 'btn btn-outline-primary'}
                                                icon={ true }
                                                defaultIcon={ 'fas fa-truck' }
                                                onClick= { () => props.onClickDispatchReliefAsst(
                                                {
                                                    user_id: reliefGood.pivot.user_id,
                                                    relief_good_id: reliefGood.pivot.relief_good_id,
                                                    recipient_id: reliefGood.pivot.recipient_id,
                                                })}
                                            />
                                        }
                                    </td>
                                    <td>
                                        <Button
                                            className={ 'btn btn-outline-danger' }
                                            icon={ true }
                                            defaultIcon={ 'fas fa-trash' }
                                            onClick={ () => props.onClickRemoveReliefAsst(
                                            {
                                                user_id: reliefGood.pivot.user_id,
                                                relief_good_id: reliefGood.pivot.relief_good_id,
                                            })}
                                        />
                                    </td>
                                </tr>
                            ))
                        ))
                    }
                </tbody>
            </table>

            {
                !props.loading && props.reliefListsTotalCount
                    ? <Pagination
                        dataCountPerPage={ props.dataCountPerPage }
                        totalCountOfData={ props.reliefListsTotalCount }
                        paginate = { props.paginate }
                        nextPage = { props.nextPage }
                        prevPage = { props.prevPage }
                        currentPage = { props.currentPage }
                    />
                    : ''
            }
        </div>
    )
}

export default React.memo(AdminReliefAsstLists);
