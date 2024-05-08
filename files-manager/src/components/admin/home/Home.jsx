import Sidebar from "../sidebar/Sidebar";
import Navbar from "../navbar/Navbar";
import { Outlet } from 'react-router-dom'; 
import "./home.scss";



const Home = () => {
  return (
    <>
    
    <div className="home">
      <Sidebar />
      <div className="homeContainer">
        <Navbar />
        <Outlet/>
      </div>
    </div>
    </>
  );
};

export default Home;
