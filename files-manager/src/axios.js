import axios from "axios";
import CryptoJS from "crypto-js";

const axiosClient = axios.create({
  baseURL: "http://127.0.0.1:8000/api"
});



axiosClient.interceptors.request.use((config) => {
    var token = localStorage.getItem("ACCESS_TOKEN");
    const csrfToken = localStorage.getItem("X-CSRF-TOKEN");
    if(token)
    {
      const bytesToken = CryptoJS.AES.decrypt(token, 'filemanager');
      token = bytesToken.toString(CryptoJS.enc.Utf8);
      config.headers.Authorization = `Bearer ${token}`;
      config.headers.Accept = "application/json";
      config.headers["Content-Type"] = "multipart/form-data";
      config.headers["X-CSRF-TOKEN"] = csrfToken;
      return config;
    }
    return config;

   
  });
  
axiosClient.interceptors.response.use(
  (response) => {
    return response;
  },
  /*(error) => {
    const { response } = error;
    if (response.status === 401) {
      localStorage.removeItem("ACCESS_TOKEN");
    }
    throw error;
  }*/
);

export default axiosClient;
