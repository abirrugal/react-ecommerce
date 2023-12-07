import React, { useState } from 'react';
import SizeInputs from '../../Includes/MultipleInput';
import Front from '../../Layouts/Front'
import { router } from '@inertiajs/react';
import axios from 'axios';
import { useForm } from '@inertiajs/react'

const Create = ({ categories, brands }) => {
  const { data, setData, post, errors } = useForm({
    name: '',
    price: '',
    discount: '',
    sizes: '',
    stock_in: '',
    description: '',
    image: '',
    images: '',
    subcategory_id: ''
  });
  const [subcategories, setSubcategories] = useState([]);

  const handleSizeDataChange = (updatedSizes) => {
    setData('sizes', updatedSizes);
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    console.log(data);
  };

  const getSubCategory = (e) => {
    setSubcategories([]);
    const categoryId = e.target.value;
    axios.get(base_url + `/admin/category/${categoryId}/subcategories`)
      .then((res) => {
        let subcategoryList = res.data.subcategories;
        const updatedSubcategories = subcategoryList.map(({ id, name }) => ({ id, name }));
        setSubcategories(updatedSubcategories);
      })
  }

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
                <select name="category_id" class="form-select" id="category_id" onChange={getSubCategory}>
                  <option>Select Category</option>
                  {categories.map(({ id, name }) => {
                    return (<option value={id}>{name}</option>)
                  })}
                </select>
              </div>
              <div class="col-sm-4 mb-3">
                <label for="subcategory_id" class="col-form-label">Sub Category Name :</label>
                <select name="subcategory_id" class="form-select" id="subcategory_id" onChange={(e) => setData('subcategory_id', e.target.value)}>
                  <option>Select Sub Category</option>
                  {subcategories.map(({ id, name }) => {
                    return (<option value={id}>{name}</option>)
                  })}
                </select>
              </div>
              <div class="col-sm-4 mb-3">
                <label for="brand_id " class="col-form-label">Brand Name :</label>
                <select name="brand_id" class="form-select" id="inputProductType">
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
                  <input type="text" id="name" name="name" onChange={(e) => setData('name', e.target.value)} minlength="3" class="form-control" placeholder="Product Name" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 mb-3">
                <label for="price" class="col-form-label">Product Price :</label>
                <div class="form-group">
                  <input type="number" id="price" name="price" onChange={(e) => setData('price', e.target.value)} class="form-control" placeholder="Product Price" />
                </div>
              </div>
              <div class="col-sm-4 mb-3">
                <label for="discount" class="col-form-label">Product Discount Price:</label>
                <div class="form-group">
                  <input type="number" id="discount" name="discount" onChange={(e) => setData('discount', e.target.value)} class="form-control" placeholder="Product discount Price" />
                </div>
              </div>
              <div class="col-sm-4 mb-3">
                <label for="stock_in" class="col-form-label">Product Current Stock :</label>
                <div class="form-group">
                  <input type="number" id="stock_in" name="stock_in" onChange={(e) => setData('stock_in', e.target.value)} class="form-control" placeholder="Product Current Stock" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 mb-3">
                <label for="description" class="col-form-label">Product Description :</label>
                <div class="form-group">
                  <textarea class="form-control" id="description" name="description" onChange={(e) => setData('description', e.target.value)} placeholder="Product Description here" ></textarea>
                </div>
              </div>
            </div>
            <div class="row">

              <SizeInputs onSizeDataChange={handleSizeDataChange} />

            </div>
            <div class="row">
              <div class="col-sm-6">
                <label for="image" class="col-form-label">Product Image :</label>
                <div class="form-group">
                  <input class="form-control" type="file" name="image" id="image" onChange="mainImage(this)" />
                  <img src=""
                    alt="Admin" height="100px" id="mainImageShow" />
                </div>
              </div>
              <div class="col-sm-6">
                <label for="image" class="col-form-label">Product Multiple Image :</label>
                <div class="form-group">
                  <input class="form-control" name="images[]" type="file" id="multiImg" multiple="" />
                  <div class="row" id="preview_img"></div>
                </div>
              </div>
            </div>
            <input type="submit" class="btn btn-primary px-4 submit" value="Add Product" />
          </form>
        </div>
      </div>
    </Front>
  );
};

export default Create;