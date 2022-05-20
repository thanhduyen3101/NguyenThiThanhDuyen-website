import React, { useEffect, useReducer, useState } from "react";
import { useNavigate } from 'react-router-dom';
import { HashLink } from 'react-router-hash-link';
import axios from "axios";
import { apiUrl } from "../../../../src/context/Constants";

import '../Header/_header.css';
import Logo from '../Logo/Logo';

function Header() {

    const [header, setHeader] = useState(false);
    // const navigate = useNavigate();

    //change color of header when scroll down
    const changeBackground = () => {
        if (window.scrollY >= 500) {
            setHeader(true);
        } else {
            setHeader(false);
        }
    };


    const login = () => {
        window.location.href = "/login";
    }
    const logout = async() => {
        // await axios.get(`${apiUrl}/auth/user/logout`);
        localStorage.removeItem("token");
        localStorage.removeItem("isAdmin");
        window.location.href = "/login";
    }

    window.addEventListener('scroll', changeBackground);

    return (
        <div className={header ? 'header' : 'header'} >
            <HashLink to='/#banner'><Logo /></HashLink>
            <div className='header-links'>
                <ul>
                    <li>
                        <HashLink to='/#program'>Các khóa học</HashLink>
                    </li>
                </ul>
                <ul>
                    <li>
                        <HashLink to='/aboutus#about-scroll'>Giới thiệu </HashLink>
                    </li>
                </ul>
                <ul>
                    <li>
                        <HashLink to='/contact#contact-scroll'>Liên hệ</HashLink>
                    </li>
                </ul>
                {localStorage.getItem("isAdmin") === "0" && localStorage.getItem("token") ?
                    (<button onClick={() => logout()}>Đăng xuất</button>) :
                    <button onClick={() => login()}>Đăng nhập</button>
                }
            </div>
        </div>
    )
}

export default Header