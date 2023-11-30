import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

const Search = ({ url }) => {
  const [searchQuery, setSearch] = useState('');

  useEffect(() => {
    const searchParams = new URLSearchParams(new URL(window.location.href).search);
    const searchValue = searchParams.get('search');

    if (searchValue) {
      setSearch(searchValue);
      router.get(url, {
        search: searchValue,
      });
    }
  }, []);

  const handleSearch = (event) => {
    const searchValue = event.target.value;
    setSearch(searchValue);

    // Save search query to localStorage
    localStorage.setItem('searchQuery', searchValue);

    router.get(url, {
      search: searchValue,
    }, {
      replace: true,
      preserveState: true,
    });
  };

  return (
    <div>
      <input
        className="form-control"
        type="text"
        value={searchQuery}
        placeholder="Search"
        onChange={handleSearch}
      />
    </div>
  );
};

export default Search;