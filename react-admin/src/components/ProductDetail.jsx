import React, { useState } from "react";
import "./ProductDetail.css";
export default function ProductDetail({
  img,
  name,
  course_name,
  content,
  setOpenModal,
}) {
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
              Tên khóa học: {course_name ? course_name : "not found"}
            </p>
            <h2 className="product-detail__name">{name}</h2>
            <div className="product-detail__button-group">
              {/* <button>Edit</button>
              <button>Delete</button> */}
            </div>
          </div>
        </div>
        <div className="product-detail__bot">
          <h2>Nội dung</h2>
          <p className="product-detail__descriptiont">{content}</p>
        </div>
      </div>
    </div>
  );
}
