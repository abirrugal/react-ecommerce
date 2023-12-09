import React, { useState, useEffect } from 'react';
import SizeInputs from '../../Includes/MultipleInput';
import Front from '../../Layouts/Front'
import axios from 'axios';
import { useForm } from '@inertiajs/react'

const Create = ({ categories, brands, variants, product }) => {
    const { data, setData, post, errors } = useForm({
        name: product.name,
        price: product.price,
        brand_id: product.brand.id,
        discount: product.discount,
        stock_in: product.stock_in,
        description: product.description,
        category_id: product.category_id,
        subcategory_id: product.subcategory_id,
        _method:'PUT'
    });
    const [subcategories, setSubcategories] = useState([]);

    const handleSizeDataChange = (updatedVariant) => {
        setData('variant', updatedVariant);
    };

    useEffect(() => {
        // Set the selected subcategory based on product.subcategory_id
        if (product.subcategory_id) {
            setData('subcategory_id', product.subcategory_id.toString());
        }
    }, [product.subcategory_id]);

    const handleSubmit = (event) => {
        event.preventDefault();
        const updatedData = { ...data };
        setData(updatedData);
        post(base_url + '/admin/product/'+product.id, data);
    };

    const handleImage = (e) => {
        const image = e.target.files[0];
        setData('image', image);
        if (image) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const imageShow = document.getElementById('mainImageShow');
                if (imageShow) {
                    imageShow.src = event.target.result;
                }
            }
            reader.readAsDataURL(image);
        }
    }

    // const handleMultipleImage = (e) => {
    //     const multipleImages = e.target.files;
    //     setData('images', multipleImages);

    //     const previewImg = document.getElementById('preview_img');
    //     previewImg.innerHTML = '';

    //     if (multipleImages) {
    //         Array.from(multipleImages).forEach((image) => {
    //             const reader = new FileReader();
    //             reader.onload = (event) => {
    //                 const imgElement = document.createElement('img');
    //                 imgElement.src = event.target.result;
    //                 imgElement.alt = 'Preview';
    //                 imgElement.style.maxWidth = '120px';
    //                 imgElement.style.marginRight = '1px';
    //                 previewImg.appendChild(imgElement);
    //             };
    //             reader.readAsDataURL(image);
    //         });
    //     }
    // }

    const handleCategoryChange = (e) => {
        const categoryId = e.target.value;
        setData('category_id', categoryId);
      };

    useEffect(() => {
        if (data.category_id) {
            axios.get(base_url + `/admin/category/${data.category_id}/subcategories`)
                .then((res) => {
                    let subcategoryList = res.data.subcategories.map(({ id, name }) => ({ id, name }));
                    setSubcategories(subcategoryList);

                    // Set the selected subcategory based on product.subcategory_id
                    if (product.subcategory_id) {
                        setData('subcategory_id', product.subcategory_id.toString());
                    }
                })
                .catch((error) => {
                    console.error('Error fetching subcategories:', error);
                });
        }
    }, [data.category_id, product.subcategory_id]);

    return (
        <Front title={'Create Product'}>
            <div class="container">
                <div class="block-header mt-5">
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Product</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Product Add</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row clearfix bg-white p-5 ">
                    <form id="basic-form" method="post" action="" enctype="multipart/form-data" onSubmit={handleSubmit}>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="category_id" class="col-form-label">Category Name :</label>
                                <select name="category_id" class="form-select" id="category_id" value={data.category_id} onChange={handleCategoryChange}>
                                    <option>Select Category</option>
                                    {categories.map(({ id, name }) => {
                                        return (<option value={id}>{name}</option>)
                                    })}
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="subcategory_id" class="col-form-label">Sub Category Name :</label>
                                <select name="subcategory_id" class="form-select" value={data.subcategory_id} id="subcategory_id" onChange={(e) => setData('subcategory_id', e.target.value)}>
                                    <option>Select Sub Category</option>
                                    {subcategories.map(({ id, name }) => {
                                        return (<option value={id}>{name}</option>)
                                    })}
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="brand_id " class="col-form-label">Brand Name :</label>
                                <select name="brand_id" class="form-select" value={data.brand_id} id="inputProductType" onChange={(e) => setData('brand_id', e.target.value)}>
                                    <option>Select Brand</option>
                                    {brands.map(({ id, name }) => {
                                        return <option value={id}>{name}</option>
                                    })}
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label for="name" class="col-form-label">Product Name :</label>
                                <div class="form-group">
                                    <input type="text" id="name" name="name" value={data.name} onChange={(e) => setData('name', e.target.value)} minlength="3" class="form-control" placeholder="Product Name" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="price" class="col-form-label">Product Price :</label>
                                <div class="form-group">
                                    <input type="number" id="price" name="price" value={data.price} onChange={(e) => setData('price', e.target.value)} class="form-control" placeholder="Product Price" />
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="discount" class="col-form-label">Product Discount (Ex: 5 for 5% discount):</label>
                                <div class="form-group">
                                    <input type="number" id="discount" name="discount" value={data.discount} onChange={(e) => setData('discount', e.target.value)} class="form-control" placeholder="Product discount Price" />
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="stock_in" class="col-form-label">Product Current Stock :</label>
                                <div class="form-group">
                                    <input type="number" id="stock_in" name="stock_in" value={data.stock_in} onChange={(e) => setData('stock_in', e.target.value)} class="form-control" placeholder="Product Current Stock" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label for="description" class="col-form-label">Product Description :</label>
                                <div class="form-group">
                                    <textarea class="form-control" id="description" value={data.description} name="description" onChange={(e) => setData('description', e.target.value)} placeholder="Product Description here" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <SizeInputs onSizeDataChange={handleSizeDataChange} variants={variants} />

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="image" class="col-form-label">Product Image :</label>
                                <div class="form-group">
                                    <input class="form-control" type="file" name="image" id="image" onChange={handleImage} />

                                    {data.image && <img src=""
                                        alt="Admin" height="100px" id="mainImageShow" className='mt-2' />}

                                </div>
                            </div>
                            {/* <div class="col-sm-6">
                                <label for="image" class="col-form-label">Product Multiple Image :</label>
                                <div class="form-group">
                                    <input class="form-control" name="images" type="file" onChange={handleMultipleImage} id="multiImg" multiple />
                                    <div class="row justify-content-center align-items-center flex-wrap p-3" id="preview_img"></div>
                                </div>
                            </div> */}
                        </div>
                        <input type="submit" class="btn btn-primary px-4 submit" value="Edit Product" />
                    </form>
                </div>
            </div>
        </Front>
    );
};

export default Create;