import "./sidebar.scss";
import DashboardIcon from "@mui/icons-material/Dashboard";
import ListIcon from '@mui/icons-material/List';
import ExitToAppIcon from "@mui/icons-material/ExitToApp";
import PublishIcon from '@mui/icons-material/Publish';
import { Link ,navigate} from "react-router-dom";



const Sidebar = () => {
  
  return (
    <div className="sidebar">
      <div className="top">
        <Link to="/" style={{ textDecoration: "none" }}>
          <span className="logo">File Meanager</span>
        </Link>
      </div>
      <hr />
      <div className="center">
        <ul>
          <p className="title">Operaction</p>
          <li>
            <Link to="import-file" style={{ textDecoration: "none" }}>
              <li>
                <PublishIcon className="icon" />
                <span>Import File</span>
              </li>
            </Link>
          </li>
          <li>
            <Link to="list-file" style={{ textDecoration: "none" }}>
              <li>
                <ListIcon className="icon" />
                <span>List File</span>
              </li>
            </Link>
          </li>
         
          <p className="title">USER</p>
          <li>
          <Link to="/logout" style={{ textDecoration: "none" }}>
              <li>
                <ExitToAppIcon className="icon" />
                <span>Logout</span>
              </li>
            </Link>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default Sidebar;
