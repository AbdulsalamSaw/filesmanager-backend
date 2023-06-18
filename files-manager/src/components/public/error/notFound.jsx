import React from 'react';
import { Link } from 'react-router-dom';


const NotFound = () => {


  return (
    <div style={{ textAlign: 'center' }}>
      <h1 style={{ fontSize: '10rem', margin: '0' }}>404</h1>
      <h2 style={{ margin: '0' }}>Page Not Found</h2>
      <p style={{ marginTop: '2rem' }}>
        Sorry, we couldn't find the page you were looking for.
      </p>
      <Link to="/" style={{ color: 'blue' }}>
        Go back to home page
      </Link>
    </div>
  );
};

export default NotFound;
