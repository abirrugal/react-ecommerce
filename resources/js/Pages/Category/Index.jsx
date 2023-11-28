import React from 'react';
import Front from './../../Layouts/Front'
import { InertiaLink } from '@inertiajs/inertia-react';
import Pagination from './../../Includes/Pagination'

function Index( data ) {
    const { categories } = data;

    return (
        <Front title="Category List">
            <div className="card my-3">
                <div className="card-header d-flex justify-content-between">
                    <h4>Categorys</h4>
                    <div>
                        <InertiaLink href={base_url + '/admin/category/create'} className="btn btn-primary">Add Category</InertiaLink>
                    </div>
                </div>
                <div className="card-body p-0">
                    <table className="table">
                        <thead className="bg-light">
                            <tr className="text-white">
                                <th scope="col">Category Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {categories.data ? (categories.data.map(({ id, name, description, image,  status }) => {
                              return  (<tr key={id}>
                                    <td>{name}</td>
                                    <td>{description}</td>
                                    <td>
                                        <img src={base_url+image} />
                                    </td>
                                    <td>{status == 1 ? 'Active':'Inactive'}</td>
                                    <td>
                                        <button className="btn btn-info text-white btn-sm mr-2">
                                            Edit
                                        </button>
                                        <button className="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </td>
                                </tr>)
                            })) : ((<tr className='alert alert-secondary text-center'><td className='my-3' colspan="6">No data found</td></tr>))}

                        </tbody>
                    </table>
                   <div className='d-flex justify-content-center'><Pagination links ={categories.links} /></div> 
                </div>
            </div>
        </Front>
    )
}

export default Index