import React from 'react'
import Front from '../../Layouts/Front'
import { useForm } from '@inertiajs/react'

function Edit({ brand }) {

    const { data, setData, post, errors } = useForm({
        name: brand.name,
        description: brand.description,
        status: brand.status,
        _method: "PUT"
    });


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
            setData('image', file)
        }
    }

    function handleSubmit(e) {
        e.preventDefault();

        const updateData = {
            ...data,
            // ...(data.image && {image:data.image})
        }
        setData(updateData);
        post(base_url + '/admin/brand/' + brand.id, updateData);
    }

    return (
        <Front >
            <div className="card col-md-8 col-lg-6 my-3">
                <div className="card-header">
                    <h4>Edit Brand</h4>
                </div>

                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="name" className="col-form-label">Brand Name :</label>
                            <div className="form-group">
                                <input type="text" id="name" name="name" value={data.name} onChange={e => setData('name', e.target.value)} className="form-control" placeholder="Brand Name" />
                            </div>
                            {errors.name && <div className='alert alert-danger'>{errors.name}</div>}
                        </div>
                        <div className="mb-3">
                            <label htmlFor="description" className="col-form-label">Brand Description :</label>
                            <div className="form-group">
                                <textarea className="form-control" name="description" value={data.description} onChange={e => setData('description', e.target.value)} placeholder="Brand Description here" id="description" ></textarea>
                            </div>
                            {errors.description && <div className='alert alert-danger'>{errors.description}</div>}
                        </div>
                        <div className="mb-3">
                            <label htmlFor="image" className="col-form-label">Brand Image:</label>
                            <div className="form-group">
                                <input type="file" name="image" onChange={handleImage} id="image" className="form-control" placeholder="Product image " />
                            </div><br />
                            {errors.image && <div className='alert alert-danger'>{errors.image}</div>}
                            <div className="mb-3">
                                <div className="col-sm-3">
                                    <h6 className="mb-0"></h6>
                                    {brand.image && <img src={base_url + '/' + brand.image} alt="Brand" id="showImage" width="250px" />}
                                </div>
                            </div>
                        </div>
                        <div className="form-check form-switch my-3">
                            <input className="form-check-input" name='status' onChange={e => setData('status', e.target.checked)} type="checkbox" id="status" checked={data.status} />
                            <label className="form-check-label" htmlForfor="status">Status</label>
                        </div>
                        <input type="submit" className="btn btn-primary px-4 submit" value="Add Brand" />
                    </form>
                </div>
            </div>

        </Front>
    )
}

export default Edit