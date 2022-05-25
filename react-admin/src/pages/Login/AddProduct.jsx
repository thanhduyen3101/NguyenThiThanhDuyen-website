import React, { useEffect, useState } from "react";
import "../../components/modal/modal.css";
import "./AddProduct.css";
import upload from "../../assets/images/upload1.jpg";
import axios from "axios";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { apiUrl } from '../../context/Constants'

function AddProduct({ setOpenModal, setValue, courseId }) {
  const [userlist, setUserlist] = useState();
  const [cateList, setCatelist] = useState();
  const [imageprev, setImageprev] = useState(upload);

  async function fetchData() {
    const response = await axios.get(
      `${apiUrl}/admin/user/shop/list`
    );
    setUserlist(response.data.data);

    const response1 = await axios.get(
      `${apiUrl}/category/list`
    );
    setCatelist(response1.data.data);
  }

  useEffect(() => {
    fetchData();
    console.log(courseId);
  }, []);

  const [title, setTitle] = useState();
  const [content, setContent] = useState();
  const [image, setImage] = useState();

  const changeImage = (event) => {
    setImage("");
    var file = event.target.files[0];
    setImage(file);
    var reader = new FileReader();
    reader.readAsDataURL(file);

    reader.onloadend = function (e) {
      setImageprev(reader.result);
    }.bind(this);
  };

  const handleOnclick = async () => {
    const formData = new FormData();
    formData.append("title", title);
    formData.append("content", content ? content : "");
    formData.append("course_id", courseId ? courseId : "");
    formData.append("image", image ? image : "");

    const data = await axios
      .post(`${apiUrl}/admin/product/create`, formData)
      .then((response) => {
        setValue(true);
        if (response.data.success) {
          toast("success");
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
    <div className="add-product">
      <div className="add-product_layout">
        <h2>Thêm bài giảng</h2>
        <span
          className="close-icon"
          onClick={() => {
            setOpenModal(false);
          }}
        >
          &times;
        </span>
        <div className="add-product_top">
          <div className="add-product_left">
            <input
              className="add-product__input"
              placeholder="Title"
              onChange={(e) => setTitle(e.target.value)}
            ></input>
            
            
           
            <textarea
              className="add-product__short-description"
              placeholder="Content"
              onChange={(e) => setContent(e.target.value)}
            ></textarea>
          </div>
          <div className="add-product_right">
            <img src={imageprev} className="add-product__img" alt="IMG"></img>

            <label for="file" className="add-product__label">
              TẢI HÌNH ẢNH LÊN
              <input
                type="file"
                id="file"
                name="image"
                className="add-product__file"
                hidden
                accept="image/png, image/jpeg"
                onChange={(e) => changeImage(e)}
              ></input>
            </label>
          </div>
        </div>

        {/* <textarea
          className="add-product__textarea"
          placeholder="Description"
        ></textarea> */}
        <div className="add-product__button-group">
          <button
            className="add-product__button-item pupble-color"
            onClick={() => handleOnclick()}
          >
            Thêm
          </button>
          <button
            className="add-product__button-item red-color"
            onClick={() => {
              setOpenModal(false);
            }}
          >
            Hủy
          </button>
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
    </div>
  );
}

export default AddProduct;
