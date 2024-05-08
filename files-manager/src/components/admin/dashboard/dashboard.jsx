import './style.scss'
import axiosClient from "../../../axios";
import { useState, useEffect } from 'react';
import { DotLoader } from 'react-spinners';


const Dashboard = () => {
    var isReport = true;
    const [loading, setLoading] = useState(false);
    const [countFile, setCountFile] = useState([]);
    const [countUser, setCountUser] = useState([]);
    useEffect(() => {
        setLoading(true)
        axiosClient.get('/report-count-file')
            .then(response => {
                if (response.status === 200) {
                    setLoading(false)
                    setCountFile(response.data.file_count);
                }
            })
            .catch(error => {
                if (isReport) {
                    setLoading(false)
                    setCountFile(0)
                    alert("There is a problem preparing the report");
                    isReport = false;
                }
            });
            axiosClient.get('/report-count-user')
            .then(response => {
                if (response.status === 200) {
                    setLoading(false)
                    setCountUser(response.data.user_count);
                }
            })
            .catch(error => {
                if (isReport) {
                    setLoading(false)
                    setCountUser(0)
                    alert("There is a problem preparing the report");
                    isReport = false;
                }
            });
    }, []);


    return (
        <div className="dashboard">
              <div class='loading-spinner'>
                <DotLoader color={'#123abc'} loading={loading} />
            </div>
            {!loading && (
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Number of Employees</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">{countUser}</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">The number of files uploaded</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">{countFile}</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            )}
        </div>
    );
}
export default Dashboard;