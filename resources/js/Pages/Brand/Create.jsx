import React from 'react'
import Front from './../../Layouts/Front'
import { useForm } from '@inertiajs/react'
import { router } from '@inertiajs/react';

function Create() {

    const {data, setData, post, processing, errors } = useForm({
        name:'',
        description:'',
        image:''
    });

    function handleSubmit(e){
        e.preventDefault();

        const updateData = {
            ...data,
            ...(data.image && {image:data.image})
        }

        post(base_url+'/admin/brand', updateData);
    }

    function handleImage(e){
        const file = e.target.files[0];
        if(file){

            const reader = new FileReader();
            reader.onload = (event)=>{
                const image = document.getElementById('showImage');
                if(image){
                    image.src = event.target.result;
                }
            }
            reader.readAsDataURL(file);
            
            setData('image', file)
        }
    }

  return (
    <Front >
    <div className="card col-md-8 col-lg-6 my-3">
    <div className="card-header">
        <h4>Add Brand</h4>
    </div>

    <div className="card-body">
        <form onSubmit={handleSubmit}>
            <div className="mb-3">
                <label htmlFor="name" className="col-form-label">Brand Name :</label>
                <div className="form-group">
                    <input type="text" id="name" name="name" onChange={e=>setData('name', e.target.value)} className="form-control" placeholder="Brand Name" />
                </div>
                {errors.name && <div className='alert alert-danger'>{errors.name}</div>}
            </div>
            <div className="mb-3">
                <label htmlFor="description" className="col-form-label">Brand Description :</label>
                <div className="form-group">
                    <textarea className="form-control"  name="description" onChange={e=>setData('description', e.target.value)} placeholder="Brand Description here" id="description" ></textarea>
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
                        {data.image && <img src="" alt="Brand"  id="showImage" width="250px" />}
                    </div>
                </div>
            </div>
            <input type="submit" className="btn btn-primary px-4 submit" value="Brand Add" />
        </form>
    </div>
</div>

    </Front>
  )
}

export default Create