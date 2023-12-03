import Front from '../../Layouts/Front';
import { useForm } from '@inertiajs/react';

const Create = (props) => {
    let { categories } = props;
    if (!categories)
        categories = [];
    // const imageRef = useRef('');
    // const [values, setValues] = useState({
    //     name: '',
    //     category_id: categories.length > 0 ? categories[0].id : '',
    // });

    // function handleChange(e) {
    //     setValues({ ...values, [e.target.name]: e.target.value })
    // }

    const { data, setData, errors, post } = useForm({
        category_id: categories && categories.length > 0 ? categories[0].id : '',
        name: '',
        status:true
    });

    function handleImage(e) {
        const file = e.target.files[0];
        setData('image', e.target.files[0]);
        if (file) {
            const reader = new FileReader();

            reader.onload = (event) => {
                const image = document.getElementById('showImage')
                image.src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function handleSubmit(e) {
        e.preventDefault()
        // values.image = imageRef.current.files[0];
        // const updatedValues = {
        //     ...values,
        //     image : imageRef.current.files[0]
        // }
        // setValues(updatedValues);
        // router.post(base_url + '/admin/subcategory', updatedValues)

        const formData = {
            ...data,
            ...(data.image && { image: data.image })
        }
        post(base_url + '/admin/subcategory', formData);
    }

    return (
        <Front title="Create Category">
            <div className="card col-md-8 col-lg-6 my-3">
                <div className="card-header">
                    <h4>Add Sub Category</h4>
                </div>
                <div className="card-body">
                    <form id="basic-form" onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="name" className="col-form-label">Name</label>
                            <div className="form-group">
                                <input type="text" id="name" name="name" onChange={e => setData('name', e.target.value)} value={data.name} className="form-control" placeholder="Name" />
                            </div>
                            {errors.name && <div className='alert alert-danger'>{errors.name}</div>}

                        </div>

                        <div className="mb-3">
                            <label for="name" className="col-form-label">Select Category :</label>
                            <div className="form-group">
                                <select name="category_id" className="form-select mb-3" value={data.category_id} aria-label="Default select example" onChange={e => setData('category_id', e.target.value)}>
                                    {categories.map(({ id, name }) => {
                                        return (<option value={id}>{name}</option>)
                                    })}

                                </select>
                            </div>
                            {errors.category_id && <div className='alert alert-danger'>{errors.category_id}</div>}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="image" className="col-form-label">Image</label>
                            <div className="form-group">
                                <input type="file" onChange={handleImage} name="image" className="form-control" placeholder="Product image " id="image" />
                            </div>
                            {errors.image && <div className='alert alert-danger'>{errors.image}</div>}
                            <div className="row mb-3">
                                <div className="col-sm-3">
                                    <h6 className="mb-0"></h6>
                                    {data.image && <img id="showImage" alt="Selected" style={{ maxWidth: '300px' }} />}
                                </div>
                            </div>
                        </div>
                        <div className="form-check form-switch my-3">
                            <input className="form-check-input" name='status' onChange={e => setData('status', e.target.checked)} type="checkbox" id="status" checked={data.status} />
                            <label className="form-check-label" htmlForfor="status">Status</label>
                        </div>
                        <button type="submit" className="btn btn-primary px-4">Add Sub Category</button>
                    </form>
                </div>
            </div>
        </Front>
    )
}

export default Create