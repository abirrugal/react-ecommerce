import React from 'react';
import Front from './../../../Layouts/Front';
import { useForm } from '@inertiajs/react';

function Create() {
  const { data, setData, post, errors } = useForm({
    name: '',
    status: true,
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    const updateData = { ...data };
    post(base_url + '/admin/attribute', updateData);
  };

  const handleStatusChange = (e) => {
    setData('status', e.target.checked);
  };

  return (
    <Front title="Add Variant">
      <div className="card col-md-8 col-lg-6 my-3">
        <div className="card-header">
          <h4>Add Variant</h4>
        </div>

        <div className="card-body">
          <form onSubmit={handleSubmit}>
            <div className="mb-3">
              <label htmlFor="name" className="col-form-label">
                Name :
              </label>
              <div className="form-group">
                <input
                  type="text"
                  id="name"
                  name="name"
                  onChange={(e) => setData('name', e.target.value)}
                  className="form-control"
                  placeholder="Name"
                />
              </div>
              {errors.name && <div className="alert alert-danger">{errors.name}</div>}
            </div>

            <div className="form-check form-switch my-3">
              <input
                className="form-check-input"
                name="status"
                onChange={handleStatusChange}
                type="checkbox"
                id="status"
                checked={data.status}
              />
              <label className="form-check-label" htmlFor="status">
                Status
              </label>
            </div>

            <input type="submit" className="btn btn-primary px-4 submit" value="Create Brand" />
          </form>
        </div>
      </div>
    </Front>
  );
}

export default Create;
