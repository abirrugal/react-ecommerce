import React, { useState, useRef } from "react";
import Front from "../Layouts/Front";
import { Inertia } from "@inertiajs/inertia";

const Create = ({user}) => {

    const [values, setValues] = useState({
        name: user.name,
        email: user.email,
        image: user.image
    })

    const myRef = useRef(null);

    function inputHandaler(e) {
        setValues({ ...values, [e.target.name]: e.target.value })
    }
    function formSubmit(e) {
        e.preventDefault()
        values._method = 'PUT';
        values.image = myRef.current.files[0];
        Inertia.post(base_url + '/users/' +user.id, values)
    }
    return (
        <Front title="Create User">
            <div className="container">
                <h4 className="mb-4 mt-2 text-center">Update {user.name}'s Profile</h4>
                <div className="card p-4">
                    <form onSubmit={formSubmit}>

                        <div className="form-group">
                            <label htmlFor="email">Name</label>
                            <input type="text" className="form-control" value={values.name} onChange={inputHandaler} name="name" id="name" placeholder="Enter Name" />
                        </div>

                        <div className="form-group">
                            <label htmlFor="image">File Upload</label>
                            <input type="file" ref={myRef} className="form-control" name="image" id="image" />
                        </div>

                        <div className="form-group">
                            <label htmlFor="email">Email address</label>
                            <input type="email" onChange={inputHandaler} value={values.email} className="form-control" name="email" id="email" placeholder="Enter email" />
                            <small id="emailHelp" className="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>

                        <button type="submit" className="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Create;