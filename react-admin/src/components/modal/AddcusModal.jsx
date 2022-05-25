import React, { useState } from 'react';

import axios from "axios";
import { apiUrl } from "../../context/Constants";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function AddcusModal({ setOpenModal, setValue}) {
    const [name, setName] = useState('');
    const [address, setAddress] = useState(''); 
    const [tel, setTel] = useState('');
    const [mail, setMail] = useState('');

    const handleOnclick = async () => {
        const formData = new FormData();
        formData.append("name", name);
        formData.append("address", address);
        formData.append("tel", tel);
        formData.append("email", mail);
        formData.append("password", "12345678");
        formData.append("sex", "1");

        const data = await axios
            .post(`${apiUrl}/admin/create`, formData)
            .then((response) => {
                toast.dismiss();
                if (response.data.success) {
                    setValue(true);
                    toast(response.data.message);
                    setTimeout(() => {
                        setOpenModal(false);
                    }, 1500);
                } else {
                    toast(response.data.message);
                }
            })
            .catch((error) => {
                if (error.response) {
                    toast(error.response.data.message);
                } else {
                    toast("Error");
                }
            });
    };
    return (
        <div className='modalBackground' style={{overflow: "scroll"}}>
            <div className='modalContainer' style={{height: "450px", marginTop: "30px"}}>
                <span
                    className="close-icon"
                    onClick={() => {
                    setOpenModal(false);
                    }}
                >
                  &times;      
                </span>
                <h2 style={{ color: "#202020" }}>Thêm giảng viên</h2>
                <input
                    type="text"
                    placeholder="Tên giảng viên"
                    className="input-text"
                    onChange={(e) => setName(e.target.value)}
                ></input>
                <input
                    type="text"
                    placeholder="Trình độ"
                    className="input-text"
                    onChange={(e) => setAddress(e.target.value)}
                ></input>
                <div className='d-flex'>
                    <input
                        type="text"
                        placeholder="Số điện thoại"
                        className="input-text"
                        onChange={(e) => setTel(e.target.value)}
                    >
                    </input>
                    <input
                        type="text"
                        placeholder="Email"
                        className="input-text"
                        onChange={(e) => setMail(e.target.value)}
                    >
                    </input>
                </div>
                {/* herre */}
                <div className='modalFooter'>
                    <button
                        className='buton-add'
                        onClick={() => handleOnclick()}
                    >
                        Thêm
                    </button>
                    <button
                        className='button-delete'
                        onClick={() => {
                            setOpenModal(false);
                        }}
                        id="cancleBtn"
                    >
                        Hủy
                    </button>
                </div>
            </div>
            <ToastContainer
                position="top-right"
                autoClose={2000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
            />
            <ToastContainer />
        </div>
    );
}

export default AddcusModal;