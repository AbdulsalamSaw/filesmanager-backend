import { useState, useEffect } from 'react';
import axiosClient from '../../../axios';
import "./style.scss";
import ModeEditIcon from '@mui/icons-material/ModeEdit';
import GetAppIcon from '@mui/icons-material/GetApp';
import { Link } from "react-router-dom";
import { saveAs } from 'file-saver';
import { DotLoader } from 'react-spinners';

const ListFile = () => {
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(false);
    useEffect(() => {
        setLoading(true)
        axiosClient.get('/report-file')
            .then(response => {
                if (response.status === 200) {
                    setLoading(false);
                    setData(response.data.files);
                }
            })
            .catch(error => {
                setLoading(false);
                alert("Something went wrong uploading your file data")
            });
    }, []);
    const exportFile = (fileId) => {
        try {
            axiosClient.get(`/export-file/${fileId}`, { responseType: 'blob' })
                .then((response) => {
                    const type = response.headers['content-type'];
                    const extension = type.split('/')[1];
                    const file = new Blob([response.data], { type });
                    saveAs(file, `file.${extension}`);
                });
        } catch (error) {
            alert("Something went wrong extracting the file");
        }
    };

    return (
        <div className='listfile'>
            <div class='loading'>
                <DotLoader color={'#123abc'} loading={loading} />
            </div>
            {!loading && (
                <table className="table">
                    <thead>
                        <tr>
                            <th scope="col">File Name</th>
                            <th scope="col">Label</th>
                            <th scope="col">Name Employee</th>
                            <th scope="col" >Upload date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.map(file => (
                            <tr scope="row" key={file.id}>
                                <td>{file.file_name}</td>
                                <td>{file.label}</td>
                                <td>{file.user.name}</td>
                                <td>{file.created_at}</td>
                                <td >
                                    <div className="row">
                                        <Link to="" onClick={() => exportFile(file.id)}>
                                            <div className="export">
                                                <GetAppIcon />
                                            </div>
                                        </Link>
                                        <Link to={{ pathname: `/home/edit-file/${file.id}`, state: { name: file.file_name } }}>
                                            <div className="edit">
                                                <ModeEditIcon />
                                            </div>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}
export default ListFile;
