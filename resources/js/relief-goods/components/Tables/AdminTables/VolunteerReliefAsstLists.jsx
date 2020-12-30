import React from 'react'
import Button from '../../Buttons/Button'
import Badge from '../../Badge/Badge'
import Field from '../../Forms/Fields'
import dispatchForm from '../../../configs/dispatchRelief.js'
import { Modal, Button as RBButton } from 'react-bootstrap'
import VolunteersReliefAssistanceHeader from './VolunteersReliefAssistanceHeader'

const AdminReliefAsstLists = (props) =>
{

    const isApproved = (approve) => approve ? 'badge bg-default' : '';
    const isDispatched = (dispatch) => dispatch ? 'table-success' : '';

    /**
     * Todo
     * Create set payload on dispatch
     */
    return (
        <div>
                <Modal
                    show={props.isModalOpen}
                    onHide={props.closeModal}
                    backdrop="static"
                    keyboard={false}
                >
                    <Modal.Header closeButton>
                        <Modal.Title>
                            Modal heading
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <Field
                            field={ dispatchForm.fields[0] }
                            onChange={ props.onChangeSetDispatchDate }
                            errorMessages={ props.errorMessages }
                        />
                    </Modal.Body>
                    <Modal.Footer>
                        <RBButton variant="secondary" onClick={props.closeModal}>
                            Close
                        </RBButton>
                        <RBButton
                            variant="primary"
                            onClick=
                            { () => props.onClickDispatchReliefAsst(
                                    {
                                        user_id: props.dispatchUserId,
                                        relief_good_id: props.dispatchReliefGoodId,
                                        recipient_id: props.dispatchRecipientId,
                                        dispatched_at: props.dispatchDate
                                    })
                            }>
                            Save Changes
                        </RBButton>
                    </Modal.Footer>
                </Modal>
            <table className="table table-hover">
                <VolunteersReliefAssistanceHeader />
                <tbody>
                {
                    props.loading
                        ?   <tr >
                                <td colSpan='6'>
                                    <img src="../../../../../storage/ssr/loading.gif" className='img w-100' alt=""/>
                                </td>
                            </tr>
                        : props.usersReliefAssistance.map( (userReliefAssistance, index) =>
                            (
                            <tr
                                key={ userReliefAssistance.id }
                                className={ isDispatched(userReliefAssistance.pivot.is_dispatched) }
                            >
                                <td>{ index + 1 } </td>
                                <td>{ userReliefAssistance.userName }</td>
                                <td>{ userReliefAssistance.name }</td>
                                <td>{ userReliefAssistance.to }</td>
                                <td>{ userReliefAssistance.pivot.dispatched_at ??= 'Soon' }</td>
                                <td>
                                    <Badge
                                        className={ isApproved(userReliefAssistance.pivot.is_dispatched) }
                                        icon={ true }
                                        successIcon={ 'far fa-thumbs-up fa-2x' }
                                        failIcon={ 'fas fa-spinner fa-2x' }
                                        status={ userReliefAssistance.pivot.is_dispatched }
                                    />
                                </td>
                                <td>
                                    {
                                        !userReliefAssistance.pivot.is_approved
                                            ? <Button
                                                className={ 'btn btn-outline-success' }
                                                onClick={ () => props.onClickApproveReliefAsst(
                                                {
                                                    user_id: userReliefAssistance.userId,
                                                    relief_good_id: userReliefAssistance.id,
                                                })}
                                                btnName={ 'Approve' }
                                            />
                                            : <Button
                                                className={ 'btn btn-warning' }
                                                onClick={ () => props.onClickDisapproveReliefAsst(
                                                {
                                                    user_id: userReliefAssistance.userId,
                                                    relief_good_id: userReliefAssistance.id,
                                                })}
                                                btnName={ 'Disapprove' }
                                        />
                                    }
                                </td>
                                <td>
                                    {
                                        !userReliefAssistance.pivot.is_received
                                            ? <Button
                                                className={ 'btn-outline-dark' }
                                                btnName={ 'Collect' }
                                                onClick={ () => props.onClickReliefAsstHasReceived(
                                                {
                                                    user_id: userReliefAssistance.userId,
                                                    relief_good_id: userReliefAssistance.id,
                                                })}
                                            />
                                            :  <Button
                                                    className={ 'btn-warning' }
                                                    btnName={ 'Collected' }
                                                    onClick={ () => props.onClickRelieveReceivedReliefAsst(
                                                    {
                                                        user_id: userReliefAssistance.userId,
                                                        relief_good_id: userReliefAssistance.id,
                                                    })}
                                                />
                                    }
                                </td>
                                <td>
                                    {
                                        !userReliefAssistance.pivot.is_dispatched // not dispatch
                                        ?
                                            <>
                                                <RBButton
                                                    variant={ 'btn btn-info' }
                                                    onClick= { () =>
                                                    {
                                                        props.onClickShowDispatchModal(
                                                        {
                                                            user_id: userReliefAssistance.userId,
                                                            relief_good_id: userReliefAssistance.id,
                                                            recipient_id: userReliefAssistance.pivot.recipient_id,
                                                            dispatched_at: userReliefAssistance.pivot.dispatched_at
                                                        });
                                                    }}
                                                > Dispatch </RBButton>
                                            </>
                                        :
                                        <Button
                                            className={ 'btn btn-warning' }
                                            icon={ true }
                                            defaultIcon={ 'fas fa-truck' }
                                            onClick= { () => props.onClickUndispatchReliefAsst(
                                                {
                                                    user_id: userReliefAssistance.userId,
                                                    relief_good_id: userReliefAssistance.id,
                                                    recipient_id: userReliefAssistance.pivot.recipient_id
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
                                            user_id: userReliefAssistance.userId,
                                            relief_good_id: userReliefAssistance.id,
                                            recipient_id: userReliefAssistance.pivot.recipient_id
                                        })}
                                    />
                                </td>
                            </tr>
                        ))
                    }
                </tbody>
            </table>
        </div>
    )
}

export default React.memo(AdminReliefAsstLists);
