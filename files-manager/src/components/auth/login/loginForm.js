import React, { useState } from 'react';
import './style.css';
import Header from './header';
import axiosClient from '../../../axios';
import CryptoJS from 'crypto-js';
import { DotLoader } from 'react-spinners';

function LoginForm() {
  const [loading, setLoading] = useState(false);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [emailError, setEmailError] = useState('');
  const [passwordError, setPasswordError] = useState('');

  const handleInputChange = (e) => {
    const { id, value } = e.target;
    switch (id) {
      case 'email':
        setEmail(value);
        break;
      case 'password':
        setPassword(value);
        break;
      default:
        break;
    }
  };

  const validate = () => {
    let emailError = '';
    let passwordError = '';

    if (!/\S+@\S+\.\S+/.test(email)) {
      emailError = 'Invalid email';
    }

    if (password.length < 6) {
      passwordError = 'Password must be at least 6 characters';
    }


    setEmailError(emailError);
    setPasswordError(passwordError);

    return !emailError && !passwordError
  };
  const handleSubmit = (e) => {
    const isValid = validate();
//25114563023
    if (isValid) {
      setLoading(true)
      const formData = new FormData();
      formData.append("email", email);
      formData.append("password", password);
      axiosClient.post("/login", formData)
        .then((response) => {
          if (response.status === 200) {
            const token = response.data.token;
            const type = response.data.type;
            if (type == 'admin') {
              window.location.href = '/admin/home/dashboard';
            } else if (type == 'staff') {
              window.location.href = '/home/list-file';
            }
            const encryptedToken = CryptoJS.AES.encrypt(token, 'filemanager').toString();
            const encryptedType = CryptoJS.AES.encrypt(type, 'filemanager').toString();
            localStorage.setItem("ACCESS_TOKEN", encryptedToken);
            localStorage.setItem('userType', encryptedType);
            setLoading(false);
           
          }
        })
        .catch((error) => {
          if (error.response.status === 401) {
            setLoading(false);
            alert("Your email or password is not correct!");
          } else if (error.response.status === 422) {
            setLoading(false);
            alert("Validation Error");
          } else {
            setLoading(false);
            alert("Error Occurred while login");
          }
        });
    }
  }
  return (
    <div className="login">
      <div className="Header">
        <Header />
        <div className="form" >
          <div className="form-body">
            <div className="email">
              <label htmlFor="email">Email</label>
              <input
                type="email"
                id="email"
                className="form-control rounded-0"
                value={email}
                onChange={(e) => handleInputChange(e)}
                placeholder="Email"
                required
              />
              <div className="error">{emailError}</div>
            </div>
            <div className="password">
              <label htmlFor="password">Password</label>
              <input
                type="password"
                id="password"
                className="form-control rounded-0"
                value={password}
                onChange={(e) => handleInputChange(e)}
                placeholder="Password"
                required
              />
              <div className="error">{passwordError}</div>
            </div>
          </div>
          <div class="col-mb-6 mb-3">
            <div class="form-group">
              <p class="text-center">
                Don't have account?{" "}
                <a href="/registration">
                  Sign up here
                </a>
              </p>
            </div>
          </div>
          <div class="footer">
            <button onClick={() => handleSubmit()} type="submit" class="btn">Log In</button>
          </div>
        </div>
      </div>
      <div className="loading-spinner">
        <DotLoader color={'#123abc'} loading={loading} />
      </div>
    </div>
  )
}

export default LoginForm