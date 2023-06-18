import "./style.scss";
import { useState } from "react";
import axiosClient from "../../../axios";
import { useNavigate } from "react-router-dom";
import { DotLoader } from 'react-spinners';

const ImportFile = () => {
  const [file, setFile] = useState("");
  const [label, setLabel] = useState("");
  const [name, setName] = useState("");
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleFormSubmit = (event) => {
    event.preventDefault();
    const formData = new FormData();
    formData.append("file", file);
    formData.append("label", label);
    formData.append("name", name);
    setLoading(true);
    axiosClient.post("/import-file", formData)
      .then((response) => {
        if (response.status === 200) {
          setLoading(false);
          alert("The file imported successfully")
          navigate("/home/list-file")
        }
      })
      .catch((error) => {
        setLoading(false);
        alert("The file imported failled")
      
      });
  }

  const handleInputChange = (e) => {
    const { id, value } = e.target;
    switch (id) {
      case "name":
        setName(value);
        break;
      case "label":
        setLabel(value);
        break;
      case "file":
        setFile(e.target.files[0]);
        break;
      default:
        break;
    }
  };

  return (
    <div className="new">
      <div className="newContainer">
        <div className="bottom">
          <div className="right">
            <form onSubmit={handleFormSubmit}>
              <div className="col-md-12">
                <label htmlFor="name">File Name</label>
                <input type="text" id="name" onChange={(e) => handleInputChange(e)} className="form-control rounded-0" placeholder="File Name" required />
                <div className="error"></div>
              </div>
              <div className="col-md-12">
                <label htmlFor="label">Label</label>
                <input type="text" id="label" onChange={(e) => handleInputChange(e)} className="form-control rounded-0" placeholder="Label" required />
                <div className="error"></div>
              </div>
              <div className="formInput col-md-12">
                <label className="form-label" htmlFor="customFile">Input File</label>
                <input type="file" id="file" onChange={(e) => handleInputChange(e)} className="form-control" required />
              </div>
              <button type="submit" className="btn btn-secondary btn-lg">
                Send
              </button>
            </form>
          </div>
        </div>
        <div className="loading-spinner">
          <DotLoader color={'#123abc'} loading={loading} />
        </div>
      </div>
    </div>

  )
};
export default ImportFile;