import Front from '../Layouts/Front';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink } from '@inertiajs/inertia-react';
import Search from '../Includes/Search';
import Pagination from '../Includes/Pagination';
import { Head, usePage, Link } from '@inertiajs/inertia-react';

const Users = ( props ) => {
    const { users } = props;
    function deleteItem(param) {
        var result = confirm("Want to delete?");
        if (result) {
            Inertia.post(base_url + '/users/' + param, { "_method": "DELETE" })
        }
    }

    return (
        <Front title="User List">
            <div className='d-flex justify-content-between'>
                <h4 className='my-4 text-center'>User List</h4>

                <Search url={base_url + '/users'} />

            </div>
            <table className="table">
                <thead className="thead-light">
                    <tr>
                        <th scope="col">Profile Image</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {users.data.length > 0 ? (users.data.map(({id,name,email,image}) => {
                        return (
                            <tr key={id}>
                                <td>{image ? (<img src={base_url + '/' + image} height="100px"  width="100px" alt="" />):("Image not found")}</td>
                                <td>{name}</td>
                                <td>{email}</td>
                                <td>
                                    <InertiaLink className='text-white' href={base_url + '/users/' + id + '/edit'}><button className='btn btn-info mr-2'> Edit </button></InertiaLink>
                                    <button className='btn btn-danger' onClick={() => deleteItem(id)}>Delete</button>
                                </td>
                            </tr>
                        )
                    }
                    )) : (<tr className='alert alert-secondary text-center'><td className='my-3' colspan="4">No data found</td></tr>)}

                </tbody>
            </table>
            <Pagination class="mt-6" links={users.links} />
        </Front>
    )
}

export default Users