import React, { useState } from 'react';

const MultipleInput = ({ onSizeDataChange }) => {
  const [sizes, setSizes] = useState([
    { attributeName: '', attributeValue: '', additionalPrice: '' },
  ]);

  const handleAddSize = () => {
    setSizes([...sizes, { attributeName: '', attributeValue: '', additionalPrice: '' }]);
  };

  const handleRemoveSize = (index) => {
    const updatedSizes = [...sizes];
    updatedSizes.splice(index, 1);
    setSizes(updatedSizes);
    onSizeDataChange(updatedSizes); // Send updated sizes data to parent
  };

  const handleInputChange = (index, event) => {
    const { name, value } = event.target;
    const updatedSizes = [...sizes];
    updatedSizes[index][name] = value;
    setSizes(updatedSizes);
    onSizeDataChange(updatedSizes); // Send updated sizes data to parent
  };

  return (
    <div>
      <table>
        <tbody>
          {sizes.map((size, index) => (
            <tr key={index}>
              <td>
                <select
                  name="attributeName"
                  className="form-select"
                  value={size.attributeName}
                  onChange={(e) => handleInputChange(index, e)}
                >
                  <option value="">Select Color</option>
                  <option value="White">White</option>
                  <option value="Black">Black</option>
                  <option value="Blue">Blue</option>
                  <option value="Green">Green</option>
                </select>
              </td>
              <td>
                <select
                  name="attributeValue"
                  className="form-select"
                  value={size.attributeValue}
                  onChange={(e) => handleInputChange(index, e)}
                >
                  <option value="">Select Size</option>
                  <option value="S">S</option>
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                </select>
              </td>
              <td>
                <input
                  type="text"
                  name="additionalPrice"
                  className="form-control"
                  placeholder="Additional Price"
                  value={size.additionalPrice}
                  onChange={(e) => handleInputChange(index, e)}
                />
              </td>
              <td>
                <button
                  type="button"
                  className="btn btn-danger btn-sm remove-table-row"
                  onClick={() => handleRemoveSize(index)}
                >
                  Remove
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <button type="button" onClick={handleAddSize}>
        Add Size
      </button>
    </div>
  );
};

export default MultipleInput;