import React, { useState } from "react";
import "./ProductDetail.css";

import axios from "axios";
import { apiUrl } from "../../src/context/Constants";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
export default function ProductDetail({
  id,
  img,
  name,
  course_name,
  content,
  setOpenModal,
}) {
  
  async function deleteCate(id) {
    await axios
      .post(`${apiUrl}/admin/product/delete/${id}`)
      .then(async (response) => {
        toast(response.data.message);
        if (response.data.success) {
          // setValue(true);
        }
      })
      .catch((error) => {
        if (error.response) {
          toast(error.response.data.message);
        } else {
          toast("Error");
        }
      });
  }

  return (
    <div className="detail-product">
      <div className="detail-product_layout">
        <span
          className="close-icon"
          onClick={() => {
            setOpenModal(false);
          }}
        >
          &times;
        </span>
        <div className="product-detail__top">
          <div className="product-detail-top-left">
            <img src={img} alt="" className="product-detail-top-left__img" />
          </div>
          <div className="product-detail-top-right">
            <p className="product-detail__cate">
              Khóa học: {course_name ? course_name : "not found"}
            </p>
            <h2 className="product-detail__name">{name}</h2>
            <div className="product-detail__bot">
              <h4>Nội dung</h4>
              <p className="product-detail__descriptiont">{content}</p>
             </div>
            {/* <div className="product-detail__button-group">
              <button>Edit</button>
              <button onClick={() => deleteCate(id)}>Delete</button>
            </div> */}
          </div>
        </div>
        
      </div>
    </div>
  );
}


