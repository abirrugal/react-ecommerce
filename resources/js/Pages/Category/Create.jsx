import React, { useRef, useState } from 'react';
import Front from '../../Layouts/Front';
import { useForm } from '@inertiajs/react';

const Create = () => {

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        image: '',
    });
    const handleSubmit = (e) => {
        e.preventDefault();

        // Prepare form data
        const formData = {
            ...data,
            ...(data.image && { image: data.image }),
        };

        post(base_url + '/admin/category', formData);
    };

    // Function to handle image selection
    function handleImageChange(e) {
        const selectedImage = e.target.files[0];
        setData('image', selectedImage);

        if (selectedImage) {
            const reader = new FileReader();

            reader.onload = (event) => {
                const image = document.getElementById('showImage');
                if (image) {
                    image.src = event.target.result;
                }
            };

            reader.readAsDataURL(selectedImage);
        }
    
}

return (
    <Front title="Create Category">
        <div className="card col-md-8 col-lg-6 my-3">
            <div className="card-header">
                <h4>Add Category</h4>
            </div>
            <div className="card-body">
                <form id="basic-form" onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label htmlFor="name" className="col-form-label">Name</label>
                        <div className="form-group">
                            <input type="text" id="name" name="name" onChange={e => setData('name', e.target.value)} value={data.name} className="form-control" placeholder="Name" />
                        </div>
                        {errors.name && <div className='alert alert-danger'>{errors.name}</div>}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="description" className="col-form-label">Description</label>
                        <div className="form-group">
                            <textarea className="form-control" name="description" onChange={e => setData('description', e.target.value)} value={data.description} placeholder="Description here" id="description" ></textarea>
                        </div>
                        {errors.description && <div className='alert alert-danger'>{errors.description}</div>}
                    </div>

                    <div className="mb-3">
                        <label htmlFor="image" className="col-form-label">Image</label>
                        <div className="form-group">
                            <input type="file" onChange={handleImageChange} name="image" className="form-control" placeholder="Product image " id="image" />
                        </div>
                        {errors.image && <div className='alert alert-danger'>{errors.image}</div>}

                        {data.image && <div className="row mb-3">
                            <div className="col-sm-3">
                                <h6 className="mb-0"></h6>
                                <img id="showImage" alt="Selected" style={{ maxWidth: '300px' }} />
                            </div>
                        </div>}

                    </div>
                    <button type="submit" className="btn btn-primary px-4">Add Category</button>
                </form>
            </div>
        </div>
    </Front>
);
};

export default Create;