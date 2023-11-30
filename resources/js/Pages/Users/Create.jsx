import React, { useState, useRef } from "react";
import Front from "../Layouts/Front";
import { router } from '@inertiajs/react'

const Create = ({ errors }) => {
    const myRef = useRef(null);
    const [values, setValues] = useState({
        name: "",
        email: "",
        image: "",
        password: "",
    })

    function inputHandaler(e) {
        setValues({ ...values, [e.target.name]: e.target.value })
    }
    function formSubmit(e) {
        e.preventDefault()
        values.image = myRef.current.files[0];
        // console.log(values);
        router.post(base_url + '/users', values)
    }
    return (
        <Front title="Create User">
            <div className="container">
                <h4 className="mb-4 mt-2 text-center">Create new user</h4>
                <div className="card p-4">
                    <form onSubmit={formSubmit} enctype="multipart/form-data">
                        <div className="form-group">
                            <label htmlFor="email">Name</label>
                            <input type="text" className="form-control" value={values.name} onChange={inputHandaler} name="name" id="name" placeholder="Enter Name" />
                            {errors.name ? (<div className="alert alert-danger mt-2">{errors.name}</div>) : ''}
                        </div>

                        <div className="form-group">
                            <label htmlFor="email">Email address</label>
                            <input type="email" onChange={inputHandaler} value={values.email} className="form-control" name="email" id="email" placeholder="Enter email" />
                            <small id="emailHelp" className="form-text text-muted">We'll never share your email with anyone else.</small>
                            {errors.email ? (<div className="alert alert-danger mt-2">{errors.email}</div>) : ''}
                        </div>

                        <div className="form-group">
                            <label htmlFor="image">File Upload</label>
                            <input type="file" ref={myRef} className="form-control" name="image" id="image" />
                        </div>

                        <div className="form-group">
                            <label htmlFor="password">Password</label>
                            <input type="password" onChange={inputHandaler} value={values.password} name="password" className="form-control" id="password" placeholder="Password" />
                            {errors.password ? (<div className="alert alert-danger mt-2">{errors.password}</div>) : ''}
                        </div>

                        <button type="submit" className="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Create;