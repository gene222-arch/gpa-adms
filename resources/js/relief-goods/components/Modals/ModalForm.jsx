import React from 'react'
import AutoForm from '../Forms/AutoForm';
import form from '../../configs/create_relief'

const ModalForm = ({ id, onSubmit, data, errorMessages }) =>
{
    /**
     * Auto fill in the form if a data is passed
     */

    return (
        <div className="modal fade" id={ id } data-backdrop="static" data-keyboard="false" tabIndex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div className="modal-dialog">
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" className="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div className="modal-body">
                        <AutoForm
                            form={ form }
                            data= { data }
                            onSubmit={ onSubmit }
                            errorMessages = { errorMessages }
                            />
                    </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" className="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default ModalForm;
