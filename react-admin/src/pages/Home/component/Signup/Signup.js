import React, { useState, useEffect, useReducer } from "react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import '../Signup/_signup.css';
import axios from "axios";
import { apiUrl } from "../../../../../src/context/Constants";

function SignupForm() {

    const [signupForm, setSignupForm] = useState({
        name: "",
        tel: "",
        email: "",
        address: "",
        password: "",
    });

    const { name, tel, email, address, password } = signupForm;

    const onChangeSignupForm = (event) =>
        setSignupForm({ ...signupForm, [event.target.name]: event.target.value });

    const signupUser = async (userForm) => {
        try {
            const response = await axios.post(`${apiUrl}/auth/user/register`, userForm);
            return response.data;
        } catch (error) {
            if (error.response.data) return error.response.data;
            else return { success: false, message: error.message };
        }
    };

    const clearAllData = () => {
        localStorage.removeItem("token");
        localStorage.removeItem("isAdmin");
      };

    const signup = async (event) => {
        event.preventDefault();
        try {
            const data = await signupUser(signupForm);
            if (data.success) {
                toast(data.message);
                clearAllData();
                window.location.href = '/login'
            } else {
                toast(data.message);
            }
        } catch (error) {
            console.log(error);
        }
    };


    return (
        <div id='sign-up' className='container-signup'>
            <div className='signup-form'>
                <form onSubmit={signup}>
                    <div>
                        <h3>Đăng ký để nhận thông tin về thời gian học</h3>
                    </div>
                    <div>
                        <label>Tên học viên (*)</label>
                        <input type='text' placeholder='Tên học viên'
                            name="name"
                            value={name}
                            onChange={onChangeSignupForm}
                        />
                    </div>
                    <div className='form-flex'>
                        <div className='col-50 mr'>
                            <label>Số điện thoại (*)</label>
                            <input type="text" placeholder="Số điện thoại"
                                name="tel"
                                value={tel}
                                onChange={onChangeSignupForm}
                            />
                        </div>
                        <div className='col-50'>
                            <label>Ngày sinh</label>
                            <input type="date" id="start-date"/>
                        </div>
                    </div>
                    <div className='form-flex'>
                        <div className='col-50 mr'>
                            <label>Email (*)</label>
                            <input type="text" placeholder="Email"
                                name="email"
                                value={email}
                                onChange={onChangeSignupForm}
                            />
                        </div>
                        <div className='col-50'>
                            <label>Địa chỉ (*)</label>
                            <input type="text" placeholder="Địa chỉ"
                                name="address"
                                value={address}
                                onChange={onChangeSignupForm}
                            />
                        </div>
                    </div>
                    <div className='form-flex'>
                        <div className='col-50 pr'>
                            <label>Password (*)</label>
                            <input type="password" placeholder="Password"
                                name="password"
                                value={password}
                                onChange={onChangeSignupForm}
                            />
                        </div>
                    </div>
                    <button type="submit">Đăng ký</button>
                </form>
            </div>
            <ToastContainer
                position="top-right"
                autoClose={3000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
            />
            {/* Same as */}
            <ToastContainer />
        </div>
    )
}

export default SignupForm