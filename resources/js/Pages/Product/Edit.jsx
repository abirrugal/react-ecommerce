import React, { useState, useEffect, useRef } from 'react';
import SizeInputs from '../../Includes/MultipleInput';
import Front from '../../Layouts/Front'
import axios from 'axios';
import { useForm } from '@inertiajs/react';
import { router } from '@inertiajs/react';

const Create = ({ categories, brands, variants, product }) => {
  const imageRef = useRef('');
  const { data, setData, post, errors } = useForm({
    name: product.name,
    status: product.status,
    price: product.price,
    brand_id: product.brand?.id || null,
    discount: product.discount,
    stock_in: product.stock_in,
    description: product.description,
    category_id: product.category_id ?? '',
    subcategory_id: product.subcategory_id,
    _method: 'PUT',
  });
  const [subcategories, setSubcategories] = useState([]);

  useEffect(() => {
    if (data.category_id) {
      axios.get(base_url + `/admin/category/${data.category_id}/subcategories`)
        .then((res) => {
          let subcategoryList = res.data.subcategories.map(({ id, name }) => ({ id, name }));
          setSubcategories(subcategoryList);

          if (product.subcategory_id) {
            setData('subcategory_id', product.subcategory_id.toString());
          }
        })
        .catch((error) => {
          console.error('Error fetching subcategories:', error);
        });
    }
  }, [data.category_id, product.subcategory_id]);

  const handleSizeDataChange = (updatedVariant) => {
    setData('variant', updatedVariant);
  };

  const handleCategoryChange = (e) => {
    const categoryId = e.target.value;
    setData('category_id', categoryId);
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

  const previwGalleryImages = (e) => {
    e.stopPropagation()
    const multipleImages = e.target.files;
    setData('images', multipleImages);

    const previewImg = document.getElementById('preview_img');
    previewImg.innerHTML = '';

    if (multipleImages) {
      Array.from(multipleImages).forEach((image) => {
        const reader = new FileReader();
        reader.onload = (event) => {
          const imgElement = document.createElement('img');
          imgElement.src = event.target.result;
          imgElement.alt = 'Preview';
          imgElement.style.maxWidth = '100px';
          imgElement.style.marginRight = '0px';
          imgElement.style.marginTop = '8px';
          previewImg.appendChild(imgElement);
        };
        reader.readAsDataURL(image);
      });
    }
  }

  const uploadGalleryImages = (e) => {
    const images = { ...data }
    setData(images);
    router.post(base_url + `/admin/product/${product.id}/addimage`, { 'images': data.images }, { preserveScroll: true });
  }

  const removeGalleryImages = (id) => {
    router.get(base_url + `/admin/product/images/${id}/delete`, {}, { preserveScroll: true });
  }

  const handleSubmit = (event) => {
    event.preventDefault();
    const updatedData = { ...data };
    setData(updatedData);
    post(base_url + '/admin/product/' + product.id, data);
  };

  return (
    <Front title="Update Product">
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
              <div class="col-sm-12 mb-2">
                <label for="name" class="col-form-label">Product Name :</label>
                <div class="form-group">
                  <input type="text" id="name" name="name" value={data.name} onChange={(e) => setData('name', e.target.value)} minlength="3" class="form-control" placeholder="Product Name" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 mb-2">
                <label for="price" class="col-form-label">Product Price :</label>
                <div class="form-group">
                  <input type="number" id="price" name="price" value={data.price} onChange={(e) => setData('price', e.target.value)} class="form-control" placeholder="Product Price" />
                </div>
              </div>
              <div class="col-sm-4 mb-2">
                <label for="discount" class="col-form-label">Product Discount (Ex: 5 for 5% discount):</label>
                <div class="form-group">
                  <input type="number" id="discount" name="discount" value={data.discount} onChange={(e) => setData('discount', e.target.value)} class="form-control" placeholder="Product discount Price" />
                </div>
              </div>
              <div class="col-sm-4 mb-2">
                <label for="stock_in" class="col-form-label">Product Current Stock :</label>
                <div class="form-group">
                  <input type="number" id="stock_in" name="stock_in" value={data.stock_in} onChange={(e) => setData('stock_in', e.target.value)} class="form-control" placeholder="Product Current Stock" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 mb-2">
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
              <div class="col">
                <label for="image" class="col-form-label">Product Image :</label>
                <div class="form-group">
                  <input class="form-control" type="file" name="image" id="image" onChange={handleImage} />
                  {product.image && <img src={base_url + '/' + product.image}
                    alt="Admin" height="100px" id="mainImageShow" className='my-2' />}
                </div>
              </div>
              <div className="form-check form-switch my-3">
                <input className="form-check-input" name='status' onChange={e => setData('status', e.target.checked)} type="checkbox" id="status" checked={data.status} />
                <label className="form-check-label" htmlForfor="status">Status</label>
              </div>
              <input type="submit" class="btn btn-primary px-4 submit my-4" value="Update Product" />
              <hr />
            </div>
          </form>
        </div>
        <div className='row bg-white p-5 my-5'>
          <h4>Gallery Images</h4>
          <div class="col-12">            
            <div class="input-group">
              <input type="file" class="form-control form-control-lg" ref={imageRef} onChange={previwGalleryImages} placeholder="Upload" aria-label="Recipient's username" aria-describedby="basic-addon2" multiple />
              <div class="input-group-append">
                <button class="btn btn-primary" onClick={uploadGalleryImages} type="button">Upload</button>
              </div>
            </div>
            <div class="row" id="preview_img"></div>
          </div>
          <div class="row">
            {product.images && (product.images.map(({ id, image }) => {
              return (<div className="col-md-3 col-xl-2">
              <div className="card mt-3" style={{ width: '12rem', position: 'relative' }}>
                <button onClick={(e) => removeGalleryImages(id)}
                  type="button"
                  className="btn   btn-secondary"
                  style={{ position: 'absolute', top: '5px', right: '5px', zIndex: '1' , backgroundColor:'rgba(0, 0, 0, 0.5)' }}
                  aria-label="Close"
                >X</button>
                <img className="card-img-top mr-3" src={base_url + '/' + image} alt="Card image cap" />
                <div className="card-body text-center py-0">
                </div>
              </div>
            </div>)
            }))
            }
          </div>
        </div>
      </div>
    </Front >
  );
};

export default Create;