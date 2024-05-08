import { useState, useEffect } from 'react';
import axiosClient from '../../../axios';
import "./style.scss";
import { Link } from "react-router-dom";
import DeleteIcon from '@mui/icons-material/Delete';
import { DotLoader } from 'react-spinners';

function User() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(false);
  useEffect(() => {
    setLoading(true)
    axiosClient.get('/report-user')
      .then(response => {
        setLoading(false)
        setUsers(response.data.users);
      })
      .catch(error => {
        setLoading(false)
        alert("Failed to retrieve data for users")
      });
  }, []);
  const deleteUser = (userId) => {
    if (window.confirm('Are you sure you want to delete this user?')) {
      axiosClient.delete(`/admin/delete-user/${userId}`)
      .then(response => {
        console.log(response.data);
        setUsers(users.filter(user => user.id !== userId));
      })
      .catch(error => {
        alert("An error occurred deleting the employee to be deleted");
      });
  }
}

  return (
    <div className='listuser'>
      <div class="row" id ="title">
        <div  class="col-md-10">
          <h3>User List</h3>
        </div>
      </div>
      <div class='loading'>
                <DotLoader color={'#123abc'} loading={loading} />
            </div>
            {!loading && (
      <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col" >Created At</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>

          {users.map(user => (
            <tr key={user.id}>
              <td>{user.id}</td>
              <td>{user.name}</td>
              <td>{user.email}</td>
              <td>{user.created_at}</td>
              <td>
              <Link to="" onClick={() => deleteUser(user.id)}>
                <div class="delete">
                  <DeleteIcon />
                </div>
              </Link>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
            )}
        
    </div>
  );
}

export default User;
