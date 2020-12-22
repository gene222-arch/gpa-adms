import React from 'react'
import ModalForm from '../Modals/ModalForm'
import Button from '../Buttons/Button'
import ModalButton from '../Buttons/ModalButton'
import Pagination from './Pagination'


const ReliefSentList = (props) =>
{
    console.log('Render Relief Sent List')
    return (
        <div>
            {/* <ModalForm
                id="exampleModal"
                onSubmit={ handleOnUpdate }
                errorMessages={ errorMessages }
                /> */}
            <table className="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>To</th>
                        <th colSpan='2'>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    {
                        props.loading
                            ?   <tr>
                                    <td colSpan='6'> <img src="../../../../../storage/ssr/loading.gif" className='img w-100' alt=""/> </td>
                                </tr>
                            : props.reliefLists.map((reliefList) => (
                            <tr key={ reliefList.id }>
                                <td>{ reliefList.id }</td>
                                <td>{ reliefList.category }</td>
                                <td>{ reliefList.name }</td>
                                <td>{ reliefList.quantity }</td>
                                <td>{ reliefList.to }</td>
                                <td>
                                    <ModalButton
                                            className='btn-warning'
                                            onClick={ () => props.handleOnEdit(reliefList.id) }
                                            action='edit'
                                            target='exampleModal'
                                        />
                                </td>
                                <td>
                                    <Button
                                        className='btn-danger'
                                        onClick={ () => props.handleOnDelete(reliefList.id) }
                                        icon={ true }
                                        defaultIcon='far fa-trash-alt'
                                    />
                                </td>
                                <td></td>
                            </tr>
                        ))
                    }
                </tbody>
            </table>
            <Pagination
                dataCountPerPage={ props.dataCountPerPage }
                totalCountOfData={ props.totalCountOfData }
                paginate={ props.paginate }
                nextPage={ props.nextPage }
                prevPage={ props.prevPage }
                currentPage={ props.currentPage }
            />
        </div>
    )
}

export default React.memo(ReliefSentList);
