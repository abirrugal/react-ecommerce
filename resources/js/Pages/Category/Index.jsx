import React from 'react';
import Front from './../../Layouts/Front'
import { Link } from '@inertiajs/react';
import Pagination from './../../Includes/Pagination'
import Search from './../../Includes/Search'
import { router } from '@inertiajs/react'

function Index(data) {
    const { categories } = data;
    function deleteItem(id) {
        var result = confirm("Want to delete?");
        if (result)
        router.post(base_url + '/admin/category/' + id, { "_method": "DELETE" });
    }

    return (
        <Front title="Category List">
            <div className="card my-3">
                <div className="card-header d-flex justify-content-between align-items-center">
                    <h4>Categories</h4>
                    <div>
                        <Search url={base_url + '/admin/category'} />
                        <Link href={base_url + '/admin/category/create'} className="btn btn-primary mt-2">Add Category</Link>
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
                            {categories.data ? (categories.data.map(({ id, name, description, image, status }) => {
                                return (<tr key={id}>
                                    <td>{name}</td>
                                    <td>{description}</td>
                                    <td>
                                        <img src={base_url + '/' + image} height="100px" width="100px" />
                                    </td>
                                    <td>{status == 1 ? 'Active' : 'Inactive'}</td>
                                    <td>
                                        <Link href={base_url + '/admin/category/' + id + '/edit'}><button className="btn btn-info text-white btn-sm mr-2">
                                            Edit
                                        </button></Link>
                                        <button className="btn btn-danger btn-sm" onClick={() => deleteItem(id)}>
                                            Delete
                                        </button>
                                    </td>
                                </tr>)
                            })) : ((<tr className='alert alert-secondary text-center'><td className='my-3' colspan="6">No data found</td></tr>))}

                        </tbody>
                    </table>
                    <div className='d-flex justify-content-center'><Pagination links={categories.links} /></div>
                </div>
            </div>
        </Front>
    )
}

export default Index