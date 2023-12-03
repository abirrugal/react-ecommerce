import React, { useRef, useState } from 'react';
import Front from '../../Layouts/Front';
import { router } from '@inertiajs/react'


const Edit = (editValue) => {
    let { category, errors } = editValue;

    if (!errors)
        errors = [];

    const imageRef = useRef('');
    const [values, setValues] = useState({
        name: category.name,
        description: category.description,
        status: category.status,
        _method: 'PUT'
    });

    function handleChange(e) {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    function handleSubmit(e) {
        e.preventDefault()
        const updatedValues = {
            ...values,
            ...(values.image && {image:values.image})
        };
        setValues(updatedValues);

        router.post(base_url + '/admin/category/' + category.id, updatedValues)
    }

    function handleImage(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const image = document.getElementById('showImage');
                if (image) {
                    image.src = event.target.result;
                }
            }
            reader.readAsDataURL(file);
            setValues({ ...values, image: file })
        }
    }

    function statusHandle(e){
        setValues({...values, status:e.target.checked})
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
                            {errors.name && <div className='alert alert-danger'>{errors.name}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="description" className="col-form-label">Description</label>
                            <div className="form-group">
                                <textarea className="form-control" name="description" onChange={handleChange} value={values.description} placeholder="Description here" id="description" ></textarea>
                            </div>
                            {errors.description && <div className='alert alert-danger'>{errors.description}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="image" className="col-form-label">Image</label>
                            <div className="form-group">
                                <input type="file" ref={imageRef} onChange={handleImage} name="image" className="form-control" placeholder="Product image " id="image" />
                            </div>
                            {errors.image && <div className='alert alert-danger'>{errors.image}</div>}
                            <div className="row mb-3">
                                <div className="col-sm-3">
                                    <h6 className="mb-0"></h6>
                                    <img src={base_url + '/' + category.image} onChange={handleImage} width="250px"
                                        alt="Admin" id="showImage" />
                                </div>
                            </div>
                        </div>
                        <div className="form-check form-switch my-3">
                            <input className="form-check-input" name='status' onChange={statusHandle} type="checkbox" id="status" checked={values.status} />
                            <label className="form-check-label" htmlForfor="status">Status</label>
                        </div>
                        <button type="submit" className="btn btn-primary px-4">Update Category</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Edit