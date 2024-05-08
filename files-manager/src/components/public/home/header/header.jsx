import React from 'react';
import "./style.css";
import CryptoJS from "crypto-js";

function Header() {
  var userType = localStorage.getItem('userType');
  if (userType) {
    const bytesToken = CryptoJS.AES.decrypt(userType, 'filemanager');
    userType = bytesToken.toString(CryptoJS.enc.Utf8);
  }
  return (
    <div className="public">
      <nav class="navbar navbar-inverse navbar-dark bg-dark">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">File Manager</a>
          </div>
          {userType === 'admin' ? (
             <ul class="nav navbar-nav navbar-right">
             <a href="/admin/home/dashboard">
               <button type="button" class="btn btn-light">Home Page</button>
             </a>
           </ul>
          ) : userType === 'staff' ? (
            <ul class="nav navbar-nav navbar-right">
              <a href="/home/list-file">
                <button type="button" class="btn btn-light">Home Page</button>
              </a>
            </ul>
          ) : (
            <ul class="nav navbar-nav navbar-right">
              <a href="/login">
                <button type="button" class="btn btn-light">Log in</button>
              </a>
            </ul>
          )
          }

        </div>
      </nav>
    </div>
  )

}
export default Header;
