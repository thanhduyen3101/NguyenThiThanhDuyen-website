import React, { useState, useEffect, useReducer } from "react";
import { Link } from "react-router-dom";
import { Form, Button } from "react-bootstrap";
import { AuthContext } from "../../context/AuthContext";
// import {  Person } from 'react-bootstrap-icons';
// import { Lock } from 'react-bootstrap-icons';
import "./login.css";
import loginImg from "../../assets/images/login3.jpg";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useHistory } from "react-router-dom";

import axios from "axios";
import { apiUrl, TOKEN } from "../../../src/context/Constants";
import setAuthToken from "../../redux/utils/setAuthToken";
import { authReducers } from "../../redux/reducers/authReducers";
import { HashLink } from "react-router-hash-link";

// import AlertMessage from '../layout/AlertMessage';

const Login = () => {

  let history = useHistory();
  // const { loginUser } = useContext(AuthContext);

  const [authState, dispatch] = useReducer(authReducers, {
    authLoading: true,
    isAuthenticated: false,
    user: null,
  });

  useEffect(() => {
    if (localStorage.getItem("isAdmin") === "0" && localStorage.getItem("token")) {
      window.location.href = "/"
    }
  }
    , []);

  const loginUser = async (userForm) => {
    try {
      const response = await axios.post(`${apiUrl}/auth/user/login`, userForm);
      if (response.data.success) {
        if (response.data.data.type_id === "STUDENT") {
          const { data } = response.data;
          localStorage.setItem(TOKEN, data.token);
          localStorage.setItem("isAdmin", data.admin);
          setAuthToken(localStorage[TOKEN]);
          dispatch({
            type: "SET_AUTH",
            payload: { isAuthenticated: true, user: response.data.user },
          });
          //   await loadUser();
        } else {
        }
      }

      return response.data;
    } catch (error) {
      if (error.response.data) return error.response.data;
      else return { success: false, message: error.message };
    }
  };

  const [loginForm, setLoginForm] = useState({
    tel: "",
    password: "",
    is_remember: true,
  });

  const { tel, password } = loginForm;

  const onChangeLoginForm = (event) =>
    setLoginForm({ ...loginForm, [event.target.name]: event.target.value });

  const login = async (event) => {
    event.preventDefault();
    try {
      const loginData = await loginUser(loginForm);
      if (loginData.success) {
        // console.log(loginData.data);
        // if (loginData.data.type_id === "ADM") {
        // history.push("/");
        
   console.log(loginData.data.token);
        window.location.href = "/";
        // } else {
        //   toast("Does Not Have Access");
        // }
      } else {
        toast(loginData.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <>
      {localStorage.getItem("isAdmin") === "0" && localStorage.getItem("token") ?
        (null):
        (<div className="Login d-flex justify-content-center align-items-center">
            <div className="content-login">
              <div className="row h-100">
                <div className="col-md-6 h-100">
                  <div className="h-100 d-flex justify-content-center align-items-center">
                    <img className="img-fluid" src={loginImg} alt="login-img" />
                  </div>
                </div>
                <div className="col-md-6 h-100">
                  <div className="d-flex justify-content-center align-items-center w-100 h-100">
                    <div className="login-form w-75 d-flex flex-column align-items-center">
                      <div className="pb-3 d-flex justify-content-center">
                        <h4>Đăng nhập</h4>
                      </div>
                      <div>
                        <Form onSubmit={login}>
                          {alert ? alert.meessage : ""}
                          {/* {alert ? alert.message : ''} */}
                          {/* <AlertMessage info={alert}></AlertMessage> */}
                          <Form.Group className="mb-3 d-flex">
                            <div className="pl-3 ipnut-icon d-flex justify-content-center align-items-center">
                              {/* <Person></Person> */}
                            </div>
                            <Form.Control
                              className="input-custom"
                              name="tel"
                              type="text"
                              placeholder="Nhập số điện thoại"
                              value={tel}
                              onChange={onChangeLoginForm}
                              required
                            />
                          </Form.Group>
                          <Form.Group className="mb-3 d-flex">
                            <div className="pl-3 ipnut-icon d-flex justify-content-center align-items-center">
                              {/* <Lock></Lock> */}
                            </div>
                            <Form.Control
                              className="input-custom"
                              name="password"
                              type="password"
                              placeholder="Mật khẩu"
                              value={password}
                              onChange={onChangeLoginForm}
                              required
                            />
                          </Form.Group>
                          <Form.Group
                            className="mb-3 text-left"
                            controlId="formBasicCheckbox"
                          >
                            <Form.Check
                              className="ml-3"
                              type="checkbox"
                              label="Ghi nhớ đăng nhập"
                            />
                          </Form.Group>
                          <Button
                            variant="success"
                            className="btn-custom"
                            type="submit"
                          >
                            Đăng nhập
                          </Button>
                          {/* <Form.Group className="mb-3 text-left">
                            <Form.Label className="forgot">
                              <Link to="/forgot">Forgot Password</Link>
                            </Form.Label>
                          </Form.Group> */}
                        </Form>
                      </div>
                      <div></div>
                    </div>
                  </div>
                </div>
              </div>
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
          </div>)
      }
    </>
  );
};

export default Login;
