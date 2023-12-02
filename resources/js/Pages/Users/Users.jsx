import React from 'react'
import Front from '../../Layouts/Front'
import Search from '../../Includes/Search'
import Pagination from '../../Includes/Pagination'

function Users({users}) {
    function getRoleName(role){
        if(role == 2){
            return 'Active'
        }
        if(role == 1){
            return 'Admin'
        }
        if(role == 0){
            return 'Inactive'
        }
    }
  return (
    <Front title="Category List">
    <div className="card my-3">
        <div className="card-header d-flex justify-content-between align-items-center">
            <h4>Users</h4>
            <div>
                <Search url={base_url + '/admin/users'} />
            </div>
        </div>
        <div className="card-body p-0">
            <table className="table">
                <thead className="bg-light">
                    <tr className="text-white">
                        <th scope="col">Name</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    {users.data ? (users.data.map(({ id, first_name, last_name, username, email, phone, role }) => {
                        return (<tr key={id}>
                            <td>{first_name+' '+last_name}</td>
                            <td>{ username}</td>
                            <td>{email}</td>
                            <td>{phone}</td>
                            <td>{getRoleName(role)}</td>
                        </tr>)
                    })) : ((<tr className='alert alert-secondary text-center'><td className='my-3' colspan="6">No data found</td></tr>))}

                </tbody>
            </table>
            <div className='d-flex justify-content-center'><Pagination links={users.links} /></div>
        </div>
    </div>
</Front>
  )
}

export default Users