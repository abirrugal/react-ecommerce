import React, { useRef, useState } from 'react';
import Front from '../../Layouts/Front';
import { router } from '@inertiajs/react'

const Create = (data) => {
    let { categories, subcategory, errors } = data;
    if (!errors)
        errors = [];
    const imageRef = useRef('');
    const [values, setValues] = useState({
        name: subcategory.name,
        status: subcategory.status,
        category_id: subcategory.category_id,
        _method: 'PUT'
    });

    function handleChange(e) {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    function handleSubmit(e) {
        e.preventDefault()
        const updatedValues = {
            ...values,
            image: imageRef.current.files[0]
        }
        setValues(updatedValues);
        router.post(base_url + '/admin/subcategory/' + subcategory.id, updatedValues)
    }

    function onStatusChange(e){
        setValues({...values, status:e.target.checked})
    }
    return (
        <Front title="Create Category">
            <div className="card col-md-8 col-lg-6 my-3">
                <div className="card-header">
                    <h4>Edit Sub Category</h4>
                </div>
                <div className="card-body">
                    <form id="basic-form" onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="name" className="col-form-label">Name</label>
                            <div className="form-group">
                                <input type="text" id="name" name="name" onChange={handleChange} value={values.name} className="form-control" placeholder="Name" />
                            </div>
                            {errors.name && <div className='alert alert-danger'>{errors.name}</div>}
                        </div>

                        <div className="mb-3">
                            <label for="name" className="col-form-label">Select Category :</label>
                            <div className="form-group">
                                <select name="category_id" className="form-select mb-3" aria-label="Default select example" onChange={handleChange}>
                                    {categories.map(({ id, name }) => {
                                        return (<option value={id} selected={id == values.category_id ? 'selected' : ''} >{name}</option>)
                                    })}

                                </select>
                            </div>
                            {errors.category_id && <div className='alert alert-danger'>{errors.category_id}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="image" className="col-form-label">Image</label>
                            <div className="form-group">
                                <input type="file" ref={imageRef} name="image" className="form-control" placeholder="Product image " id="image" />
                            </div>
                            {errors.image && <div className='alert alert-danger'>{errors.image}</div>}
                            <div className="row mb-3">
                                <div className="col-sm-3">
                                    <h6 className="mb-0"></h6>
                                    <img src={base_url + '/' + subcategory.image} width="250px"
                                        alt="Admin" id="showImage" />
                                </div>
                            </div>
                        </div>
                        <div className="form-check form-switch my-3">
                            <input className="form-check-input" name='status' onChange={onStatusChange} type="checkbox" id="status" checked={values.status} />
                            <label className="form-check-label" htmlForfor="status">Status</label>
                        </div>
                        <button type="submit" className="btn btn-primary px-4">Add Sub Category</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Create