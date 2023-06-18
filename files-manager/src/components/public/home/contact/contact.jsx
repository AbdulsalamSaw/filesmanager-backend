import React from "react";
import './contact.scss'
import axiosClient from "../../../../axios";
import { useState } from "react";

const Contact = () =>{
    const [name, setName] = useState("");
    const [emal, setEmail] = useState("");
    const [subject, setSbject] = useState("");
    const [message, setMessage] = useState("");

  const handleFormSubmit = (event) => {
    
    
    event.preventDefault();
    const formData = new FormData();
    formData.append("name", name);
    formData.append("emal", emal);
    formData.append("subject", subject);
    formData.append("message", message);
    axiosClient.post("/owner/contact", formData)
      .then((response) => {
        alert("The Send Message successfully")
        console.log(response.data);
      })
      .catch((error) => {
        alert("fail")
        console.log(error);
      });
  }
  const handleInputChange = (e) => {
    const { id, value } = e.target;
    switch (id) {
      case "name":
        setName(value);
        break;
      case "email":
        setEmail(value);
        break;
      case "subject":
        setSbject(value);
        break;
        case "message":
        setMessage(value);
        break;
      default:
        break;
    }
  };
    return (
            <div class="container">
                <div class="col-12 text-center">
                    <h1>Contact Us</h1>
                </div>
                <br/>
                <div class="img_contact">
                    <div class="contact shadow p-3 mb-5 bg-white rounded">
                        <form onSubmit={handleFormSubmit}>
                            <div class="row">
                                <h3 class="text-black mb-1">Contact Form</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name"> Name</label>
                                    <input type="text"onChange={(e) => handleInputChange(e)} id="name" name="name" className="form-control rounded-0"  placeholder="Abd" />
                                    <div className="error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" onChange={(e) => handleInputChange(e)} id="email" name="email" className="form-control rounded-0"  placeholder="@mail" />
                                    <div className="error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="subject">Subject</label>
                                    <input type="text" onChange={(e) => handleInputChange(e)} id="subject" name="subject" className="form-control rounded-0"  placeholder="Subject" />
                                    <div className="error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="text-black" for="message">Message</label>
                                    <textarea onChange={(e) => handleInputChange(e)} id="message" name="message" cols="30" rows="7" className="form-control rounded-0"  placeholder="Leave your message here..."></textarea>
                                    <div className="error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-primary rounded-pill" type="submit" >Submit form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br/>
                </div>
            </div>
    );
}

export default Contact;