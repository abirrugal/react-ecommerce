import React, { useRef, useState } from 'react';
import Front from '../../Layouts/Front';
import { Inertia } from '@inertiajs/inertia';

const Create = (data) => {
    const {categories} = data;

    const imageRef = useRef('');
    const [values, setValues] = useState({
        name: '',
        category_id: categories.length > 0 ? categories[0].id : '',
    });

    function handleChange(e) {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    function handleSubmit(e) {
        e.preventDefault()
        values.image = imageRef.current.files[0];
        const updatedValues = {
            ...values,
            image : imageRef.current.files[0]
        }
        setValues(updatedValues);
        Inertia.post(base_url + '/admin/subcategory', updatedValues)
    }

    return (
        <Front title="Create Category">
            <div className="card col-md-8 col-lg-6 my-3">
                <div className="card-header">
                    <h4>Add Sub Category</h4>
                </div>
                <div className="card-body">
                    <form id="basic-form" onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="name" className="col-form-label">Name</label>
                            <div className="form-group">
                                <input type="text" id="name" name="name" onChange={handleChange} value={values.name} className="form-control" placeholder="Name" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="col-form-label">Select Category :</label>
                            <div class="form-group">
                                <select name="category_id" class="form-select mb-3" aria-label="Default select example" onChange={handleChange}>
                                    {categories.map(({id, name})=>{
                                        return(<option value={id}>{name}</option>)
                                    })}
                                                  
                                </select>
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
                                    <img src=""
                                        alt="Admin" id="showImage" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" className="btn btn-primary px-4">Add Sub Category</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Create