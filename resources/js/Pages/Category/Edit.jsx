import React, { useRef, useState } from 'react';
import Front from '../../Layouts/Front';
import { router } from '@inertiajs/react'


const Edit = (editValue) => {
    const { category } = editValue;

    const imageRef = useRef('');
    const [values, setValues] = useState({
        name: category.name,
        description: category.description,
        _method: 'PUT'
    });

    function handleChange(e) {
        console.log('Clicked');
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    function handleSubmit(e) {
        e.preventDefault()
        values.image = imageRef.current.files[0];
        values._method = 'PUT';

        const updatedValues = {
            ...values,
            image: imageRef.current.files[0],
            _method: 'PUT',
        };

        setValues(updatedValues);
        router.post(base_url + '/admin/category/' + category.id, updatedValues)
    }

    return (
        <Front title="Create Category">
            <div className="card col-md-8 col-lg-6 my-3">
                <div className="card-header">
                    <h4>Edit Category</h4>
                </div>
                <div className="card-body">
                    <form id="basic-form" onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="name" className="col-form-label">Name</label>
                            <div className="form-group">
                                <input type="text" id="name" name="name" onChange={handleChange} value={values.name} className="form-control" placeholder="Name" />
                            </div>
                        </div>

                        <div className="mb-3">
                            <label htmlFor="description" className="col-form-label">Description</label>
                            <div className="form-group">
                                <textarea className="form-control" name="description" onChange={handleChange} value={values.description} placeholder="Description here" id="description" ></textarea>
                            </div>
                        </div>

                        <div className="mb-3">
                            <label htmlFor="image" className="col-form-label">Image</label>
                            <div className="form-group">
                                <input type="file" ref={imageRef} name="image" className="form-control" placeholder="Product image " id="image" />
                            </div>
                            <div className="row mb-3">
                                <div className="col-sm-3">
                                    <h6 className="mb-0"></h6>
                                    <img src={base_url + '/' + category.image}
                                        alt="Admin" id="showImage" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" className="btn btn-primary px-4">Update Category</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Edit