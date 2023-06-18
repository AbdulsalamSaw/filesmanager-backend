import "./style.scss";
import { useState } from "react";
import axiosClient from "../../../axios";
import { useNavigate } from "react-router-dom";
import { DotLoader } from 'react-spinners';


const AddUser = () => {
    const [loading, setLoading] = useState(false);
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const navigate = useNavigate();
    const [nameError, setNameError] = useState('');
    const [emailError, setEmailError] = useState('');
    const [passwordError, setPasswordError] = useState('');
    const [confirmPasswordError, setConfirmPasswordError] = useState('');

    const handleFormSubmit = (event) => {
        event.preventDefault();
        const formData = new FormData();

        formData.append("name", name);
        formData.append("email", email);
        formData.append("password", password);

        setLoading(true)
        axiosClient.post("/register-employee", formData)
        
            .then((response) => {
                if (response.status === 200) {
                    setLoading(false);

                    alert("The employee added successfully")
                    navigate("/admin/home/users");
                }
            })
            .catch((error) => {
                if (error.response.status === 404) {
                    setLoading(false)
                    alert("This employee is already exist!");
                }else
                {
                    alert("An error occurred while adding the employee, try again");

                }
            });
    }

    const handleInputChange = (e) => {
        const { id, value } = e.target;
        switch (id) {
            case 'name':
                setName(value);
                break;
            case 'email':
                setEmail(value);
                break;
            case 'password':
                setPassword(value);
                break;
            case 'confirmPassword':
                setConfirmPassword(value);
                break;
            default:
                break;
        }
    };
    const validate = () => {
        let nameError = '';
        let emailError = '';
        let passwordError = '';
        let confirmPasswordError = '';

        if (!name) {
            nameError = 'Name is required';
        }

        if (!/\S+@\S+\.\S+/.test(email)) {
            emailError = 'Invalid email';
        }

        if (password.length < 6) {
            passwordError = 'Password must be at least 6 characters';
        }

        if (confirmPassword !== password) {
            confirmPasswordError = 'Passwords do not match';
        }

        setNameError(nameError);
        setEmailError(emailError);
        setPasswordError(passwordError);
        setConfirmPasswordError(confirmPasswordError);

        return !nameError && !emailError && !passwordError && !confirmPasswordError;
    };

    const handleSubmit = (e) => {
        const isValid = validate();

        if (isValid) {
            console.log(name, email, password, confirmPassword);
        }
    };

    return (
        <div className="adduser">
            <div className="register">
                <div class="row" id="title">
                    <div class="col-md-12 mb-3">
                        <h2>Add New Employee</h2>
                    </div>
                </div>
                <form onSubmit={handleFormSubmit}>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label htmlFor="name">Name</label>
                            <input type="name" id="name" className="form-control rounded-0" onChange={(e) => handleInputChange(e)} placeholder="UserName" maxLength={32} required />
                            <div className="error">{nameError}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label htmlFor="email">Email</label>
                            <input type="email" id="email" className="form-control rounded-0" onChange={(e) => handleInputChange(e)} placeholder="Email" required />
                            <div className="error">{emailError}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label htmlFor="password">Password</label>
                            <input id="password" type="password" className="form-control rounded-0" onChange={(e) => handleInputChange(e)} placeholder="Password" required />
                            <div className="error">{passwordError}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label htmlFor="confirmPassword">Confirm Password</label>
                            <input id="confirmPassword" type="password" className="form-control rounded-0" onChange={(e) => handleInputChange(e)} value={confirmPassword} placeholder="Confirm Password" />
                            <div className="error">{confirmPasswordError}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-secondary btn-lg" > Add </button>
                        </div>
                    </div>
                </form>
                <div className="loading-spinner">
                <DotLoader color={'#123abc'} loading={loading} />
            </div>
            </div>

        </div>

    );
}
export default AddUser;