import React from 'react'
import Front from './../../Layouts/Front'
import Pagination from './../../Includes/Pagination'
import Search from '../../Includes/Search'
import { Link } from '@inertiajs/react'

function Index({ orders }) {

    return (
        <Front title="Order List">
            <div class="card my-3">
            <div className="card-header d-flex justify-content-between align-items-center">
                    <h4>Categories</h4>
                    <div>
                        <Search url={base_url + '/admin/order'} />
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="text-white">
                                <th scope="col">User Name</th>
                                <th scope="col">Order Id</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                                {orders && orders.data.map(({ id, order_id, total_price, status, payment_status, processed_by, payment_method_id, delivery_charge, user }) => {
                                    return (
                                        <tr id={id}>
                                            <td>{user.username}</td>
                                            <td>{order_id}</td>
                                            <td>{total_price}</td>
                                            <td>{status == 1? 'Active':'Inactive'}</td>
                                            <td>
                                                <a href="{{ route('order.details',$item->id) }}" class="btn btn-info text-white btn-sm">
                                                    <i data-feather="eye" class="nav-icon icon-xs"></i>
                                                </a>
                                                <Link href={base_url + `/admin/orders/${id}/invoice`} target="_blank" class="btn btn-info text-white btn-sm">Invoice</Link>
                                            </td>
                                            </tr>
                                            )
                                })}             
                        </tbody>
                    </table>
                    <Pagination links={orders.links}/>
                </div>
            </div>

        </Front>
    )
}

export default Index