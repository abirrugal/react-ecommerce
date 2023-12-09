import React, { useState } from 'react';

const MultipleInput = ({ onSizeDataChange, variants }) => {
  const [productVariant, setVariant] = useState([
    { attributeName: '', attributeValue: '', additionalPrice: '' },
  ]);
  // console.log(variants);

  const handleAddSize = () => {
    setVariant([...productVariant, { attributeName: '', attributeValue: '', additionalPrice: '' }]);
  };

  const handleRemoveSize = (index) => {
    const updatedSizes = [...productVariant];
    updatedSizes.splice(index, 1);
    setVariant(updatedSizes);
    onSizeDataChange(updatedSizes); // Send updated sizes data to parent
  };

  const handleInputChange = (index, event) => {
    const { name, value } = event.target;
    const updatedSizes = [...productVariant];
    updatedSizes[index][name] = value;
    setVariant(updatedSizes);
    onSizeDataChange(updatedSizes); // Send updated sizes data to parent
  };

  return (
    <div>
      <table>
        <tbody>
          {productVariant.map((variant, index) => (
            <tr key={index}>
              <td>
                <select name="attributeName" value={variant.attributeName} class="form-select" id="category_id" onChange={(e) => handleInputChange(index, e)}>
                  <option>Select Variant</option>
                  {variants.map(({ name }) => {
                    return (<option value={name.toLowerCase()}>{name}</option>)
                  })}
                </select>
              </td>

              <td>
                <input
                  type="text"
                  name="attributeValue"
                  className="form-control"
                  placeholder="Variant Value Ex:(red, XL)"
                  value={variant.attributeValue}
                  onChange={(e) => handleInputChange(index, e)}
                />
              </td>
              <td>
                <input
                  type="text"
                  name="additionalPrice"
                  className="form-control"
                  placeholder="Additional Price"
                  value={variant.additionalPrice}
                  onChange={(e) => handleInputChange(index, e)}
                />
              </td>
              <td>

                <button type="button" className="btn btn-danger remove-table-row" onClick={() => handleRemoveSize(index)}>Remove</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <button type="button" className='btn btn-primary remove-table-row mt-2' onClick={handleAddSize}>
        Add Size
      </button>
    </div>
  );
};

export default MultipleInput;