import React, { useState } from 'react';
import MultipleInput from './../../Includes/MultipleInput';
import Front from './../../Layouts/Front'

const FormComponent = () => {
  const [otherFormData, setOtherFormData] = useState({name:''});
  const [sizes, setSizes] = useState([
    { attributeName: '', attributeValue: '', additionalPrice: '' },
  ]);

  const handleSizeDataChange = (updatedSizes) => {
    setSizes(updatedSizes); // Update sizes data in FormComponent state
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    // Handle form submission, including otherFormData and sizes state
    console.log(sizes);
  };

  return (
    <Front>
    <form onSubmit={handleSubmit}>
      {/* Other form fields */}
      {/* For example: */}
      <input 
        type="text"
        name="fieldName"
        value={otherFormData.name}
        onChange={(e) => setOtherFormData({ ...otherFormData, fieldName: e.target.value })}
      />

      {/* Render SizeInputComponent and pass onSizeDataChange as a prop */}
      <MultipleInput onSizeDataChange={handleSizeDataChange} />

      {/* Submit button */}
      <button type="submit">Submit</button>
    </form>
    </Front>
  );
};

export default FormComponent;