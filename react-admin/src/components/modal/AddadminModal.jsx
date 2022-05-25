import React, { useEffect, useState } from "react";

import "./modal.css";

import axios from "axios";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import {apiUrl} from '../../context/Constants'
function AddadminModal({ setOpenModal, setValue }) {
  const [name, setName] = useState();
  const [email, setEmail] = useState();
  const [password, setPassword] = useState();
  const [address, setAddress] = useState();
  const [tel, setTel] = useState();
  const [sex, setSex] = useState();

  const handleOnclick = async () => {
    const formData = new FormData();
    formData.append("name", name);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("phone", tel);
    formData.append("sex", sex);
    formData.append("address", address);

    const data = await axios
      .post(`${apiUrl}/admin/create`, formData)
      .then((response) => {
        toast.dismiss();
        if (response.data.success) {
          toast(response.data.message);
          setValue(true);
          setTimeout(() => {
            setOpenModal(false);
          }, 1000);
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
    <div className="modalBackground">
      <div className="modalContainer">
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
          type="email"
          placeholder="Email"
          className="input-text"
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          type="password"
          placeholder="Password"
          className="input-text"
          onChange={(e) => setPassword(e.target.value)}
        />
        <div className="add-admin__group">
          <input
            type="text"
            placeholder="Name"
            className="input-text"
            onChange={(e) => setName(e.target.value)}
          />
          <input
            type="text"
            placeholder="Address"
            className="input-text"
            onChange={(e) => setAddress(e.target.value)}
          />
        </div>

        <div className="add-admin__group">
          <input
            type="text"
            placeholder="Tel"
            className="input-text"
            name="tel"
            onChange={(e) => setTel(e.target.value)}
          />

          <select
            className="input-text"
            onChange={(e) => setSex(e.target.value)}
          >
            <option value="select">Sex</option>
            <option value="0">Male</option>
            <option value="1">FeMale</option>
          </select>
        </div>

        <div className="modalFooter1">
          <button className="buton-add" onClick={() => handleOnclick()}>
            Add
          </button>
          <button
            className="button-delete"
            onClick={() => {
              setOpenModal(false);
            }}
            id="cancelBtn"
          >
            Cancel
          </button>
        </div>
      </div>
      {/* <ToastContainer
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
      <ToastContainer /> */}
    </div>
  );
}

export default AddadminModal;
