import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Registration from './components/auth/registration/registrationForm';
import Login from './components/auth/login/loginForm';
import Logout from './components/auth/logout/logout';
import Home from './components/public/home/home';
import NotFound from './components/public/error/notFound';

import AdminHome from './components/admin/home/Home';
import AdminUsers from './components/admin/user/user';
import AdminAddUser from './components/admin/user/addUser';
import AdminImportFile from './components/admin/file/ImportFile';
import AdminListFile from './components/admin/file/listFile';
import AdminEditFile from './components/admin/file/editFile';
import AdminDashboard from './components/admin/dashboard/dashboard';

import StaffHome from './components/staff/home/Home';
import StaffImportFile from './components/staff/file/ImportFile';
import StaffEditFile from './components/staff/file/editFile';
import StaffListFile from './components/staff/file/listFile';
import CryptoJS from "crypto-js";


function Router() {
  var userType = localStorage.getItem('userType');
  if(userType)
  {
    const bytesToken = CryptoJS.AES.decrypt(userType, 'filemanager');
    userType = bytesToken.toString(CryptoJS.enc.Utf8);
  }

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/login" element={<Login />} />
        <Route path="/registration" element={<Registration />} />
        <Route path="/logout" element={<Logout />} />
        {userType === 'admin'  ? (
          <Route path="/admin/home" element={<AdminHome/>}>
            <Route path="dashboard" element={<AdminDashboard/>} />
            <Route path="users" element={<AdminUsers/>} />
            <Route path="import-file" element={<AdminImportFile/>} />
            <Route path="add-user" element={<AdminAddUser/>} />
            <Route path="list-file" element={<AdminListFile/>} />
            <Route path="edit-file/:id" element={<AdminEditFile />} />
          </Route>
        ) : userType === 'staff' ? (
            <Route path="/home" element={<StaffHome />}>
            <Route path="import-file" element={<StaffImportFile />} />
            <Route path="edit-file/:id" element={<StaffEditFile />} />
            <Route path="list-file" element={<StaffListFile/>} />
          </Route>
        ) : (
          <Route path="/404" element={<NotFound />} />
        )}
        <Route path="*" element={<NotFound />} />
      </Routes>
    </BrowserRouter>
  );
}

export default Router;
