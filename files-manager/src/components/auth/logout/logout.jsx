import { useEffect } from 'react';
import { useNavigate } from "react-router-dom";
import axiosClient from '../../../axios';
//logout
function Logout() {
  const navigate = useNavigate();
  useEffect(() => {    
    localStorage.clear();
    axiosClient.post("/logout")
    .then((response) => {
      navigate("/");
    })
    .catch((error) => {
      console.log(error);
      navigate("/");
    });
  }, [navigate]);

  return null;
}

export default Logout;
